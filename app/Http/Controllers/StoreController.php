<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\StoreTypeEnum;
use App\Http\Requests\Store\StoreAcceptanceRequest;
use App\Http\Requests\Store\StoreMoveSuppliesRequest;
use App\Http\Requests\Store\StoreOrderCreateRequest;
use App\Http\Requests\Store\StoreUpdateRequest;
use App\Http\Requests\Store\StoreWriteOffSuppliesRequest;
use App\Models\Provider;
use App\Models\Store;
use App\Models\Supply;
use App\Models\SupplyInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StoreController
{
    public function catalog(Store $store): View
    {
        /* @var Collection<int, Supply> $supplies */
        $supplies = $store->suppliesInStock()->with('supplyInfo')->get();

        $result = [];
        foreach ($supplies as $supply) {
            $result[] = [
                'name' => $supply->supplyInfo->name,
                'price' => $supply->supplyInfo->price,
                'description' => $supply->supplyInfo->description,
                'quantity' => $supply->quantity,
                'id' => $supply->id,
            ];
        }

        return view('store.catalog', [
            'supplies' => $result,
            'nameStore'=> $store->name,
            'storeId' => $store->id,
        ]);
    }

    public function index(): View
    {
        $stores = Store::all();

        $preparedList = [];
        foreach ($stores as $item) {
            $preparedList[] = [
                'name' => $item->name,
                'type' => $item->type,
                'address' => $item->address,
                'id' => $item->id,
            ];
        }

        return view('store.index', [
            'storeList' => $preparedList,
        ]);
    }

    public function edit(Store $store) :View
    {
        return view('store.edit', [
            'store' => $store,
            'storeTypes' => StoreTypeEnum::cases(),
        ]);

    }

    public function update(Store $store, StoreUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $store->update($data);

        return redirect()->route('stores.index');
    }

    public function order(Store $store): View
    {
        $supplyList = SupplyInfo::with('providers')->get();
        $stock = $store->suppliesInStock()->pluck('quantity', 'id')->toArray();
        $preparedList = [];
        foreach ($supplyList as $supply) {
            /* @var SupplyInfo $supply */
            $preparedList[] = [
                'id' => $supply->id,
                'name' => $supply->name,
                'price' => $supply->price,
                'quantity' => $stock[$supply->id] ?? 0,
                'providers' => $supply->providers->pluck('name', 'id')->toArray(),
            ];
        }

        return view('store.order', [
            'supplyList' => $preparedList,
            'storeId' => $store->id,
            'storeName' => $store->name,
        ]);
    }

    public function moveSupplies(Store $store): View
    {
        $supplies = $store->suppliesInStock()->with('supplyInfo')->get();
        $preparedList = [];
        foreach ($supplies as $supply) {
            /* @var Supply $supply */
            $preparedList[] = [
                'id' => $supply->supplyInfo->id,
                'name' => $supply->supplyInfo->name,
                'price' => $supply->supplyInfo->price,
                'quantity' => $supply->quantity,
            ];
        }

        $stores = Store::where('id', '!=', $store->id)->pluck('name', 'id')->toArray();

        return view('store.move-supplies', [
            'supplyList' => $preparedList,
            'storeId' => $store->id,
            'storeName' => $store->name,
            'stores' => $stores,
        ]);
    }

    public function acceptance(Store $store): View
    {
        $supplyList = SupplyInfo::with('providers')->get();
        $preparedList = [];
        foreach ($supplyList as $supply) {
            /* @var SupplyInfo $supply */
            $preparedList[] = [
                'id' => $supply->id,
                'name' => $supply->name,
                'price' => $supply->price,
            ];
        }

        return view('store.acceptance', [
            'supplyList' => $preparedList,
            'storeId' => $store->id,
            'storeName' => $store->name,
        ]);
    }

    public function storeOrder(Store $store, StoreOrderCreateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $orderList = [];
        foreach ($data['quantity'] as $supplyId => $quantity) {
            if ($quantity > 0) {
                $orderList[$supplyId]['quantity'] = $quantity;
                $orderList[$supplyId]['provider'] = $data['providers'][$supplyId];
            }
        }

        if (0 === count($orderList)) {
            return redirect()->route('stores.catalog', $store->id)->with('error', 'Сформирована заявка с пустым списком товаров');
        }

        // Код отправки заявки должен быть здесь, в рамках задания не реализовано

        $supplies = SupplyInfo::whereIn('id', array_keys($orderList))->pluck('name', 'id')->toArray();
        $providers = Provider::whereIn(
            'id',
            array_map(
                fn(array $item) => $item['provider'],
                $orderList
            )
        )->pluck('name', 'id')->toArray();

        $popupText = 'Сформирована заявка:<br>';
        foreach ($supplies as $id => $supply) {
            $popupText .= $orderList[$id]['quantity'] . 'шт ' . $supply . ', ' . $providers[$orderList[$id]['provider']] . '<br>';
        }

        return redirect()->route('stores.catalog', $store->id)->with('success', $popupText);
    }

    public function storeAcceptance(Store $store, StoreAcceptanceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $acceptanceList = [];
        foreach ($data['quantity'] as $supplyId => $quantity) {
            if ($quantity > 0) {
                $acceptanceList[$supplyId] = $quantity;
            }
        }

        if (0 === count($acceptanceList)) {
            return redirect()->route('stores.catalog', $store->id)->with('error', 'Пустой список принятых товаров');
        }

        $supplies = SupplyInfo::whereIn('id', array_keys($acceptanceList))->pluck('name', 'id')->toArray();
        $storeSupplies = $store->supplies->keyBy('supply_info_id');

        $popupText = 'Приняты товары:<br>';
        foreach ($supplies as $id => $supply) {
            $popupText .= $acceptanceList[$id] . 'шт ' . $supply .  '<br>';

            if (null !== $storeSupply = $storeSupplies->get($id)) {
                $storeSupply->quantity += $acceptanceList[$id];
                $storeSupply->save();
            } else {
                Supply::create([
                    'store_id' => $store->id,
                    'supply_info_id' => $id,
                    'quantity' => $acceptanceList[$id],
                ]);
            }
        }

        return redirect()->route('stores.catalog', $store->id)->with('success', $popupText);
    }

    public function storeMoveSupplies(Store $store, StoreMoveSuppliesRequest $request): RedirectResponse
    {
        $data = $request->validated();
        /** @var Collection<int, Supply> $ourStoreSupplies */
        $ourStoreSupplies = $store->suppliesInStock()->with('supplyInfo')->get()->keyBy('supply_info_id');

        $moveList = [];
        foreach ($data['quantity'] as $supplyId => $quantity) {
            if (
                (int) $quantity > 0
                && $ourStoreSupplies->has($supplyId)
                && $ourStoreSupplies->get($supplyId)->quantity > 0
            ) {
                $moveList[$supplyId] = min((int) $quantity, $ourStoreSupplies->get($supplyId)->quantity);
            }
        }

        if (0 === count($moveList)) {
            return redirect()->route('stores.catalog', $store->id)->with('error', 'Пустой список передачи товаров');
        }

        /** @var Store $targetStore */
        $targetStore = Store::whereId($data['store'])->first();
        $targetStoreSupplies = $targetStore->supplies->keyBy('supply_info_id');

        $popupText = 'В торговую точку "' . $targetStore->name . '" переданы товары:<br>';
        foreach ($moveList as $id => $quantity) {
            $ourSupply = $ourStoreSupplies->get($id);
            $popupText .= $quantity . 'шт ' . $ourSupply->supplyInfo->name .  '<br>';

            $ourSupply->quantity -= $quantity;
            $ourSupply->save();

            if (null !== $targetSupply = $targetStoreSupplies->get($id)) {
                $targetSupply->quantity += $quantity;
                $targetSupply->save();
            } else {
                Supply::create([
                    'store_id' => $targetStore->id,
                    'supply_info_id' => $id,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->route('stores.catalog', $store->id)->with('success', $popupText);
    }

    public function writeOffSupplies(Store $store): View
    {
        $supplies = $store->suppliesInStock()->with('supplyInfo')->get();
        $preparedList = [];
        foreach ($supplies as $supply) {
            /* @var Supply $supply */
            $preparedList[] = [
                'id' => $supply->supplyInfo->id,
                'name' => $supply->supplyInfo->name,
                'price' => $supply->supplyInfo->price,
                'quantity' => $supply->quantity,
            ];
        }

        return view('store.write-off-supplies', [
            'supplyList' => $preparedList,
            'storeId' => $store->id,
            'storeName' => $store->name,
        ]);
    }

    public function storeWriteOffSupplies(Store $store, StoreWriteOffSuppliesRequest $request): RedirectResponse
    {
        $data = $request->validated();
        /** @var Collection<int, Supply> $storeSupplies */
        $storeSupplies = $store->suppliesInStock()->with('supplyInfo')->get()->keyBy('supply_info_id');

        $writeOffList = [];
        foreach ($data['quantity'] as $supplyId => $quantity) {
            if (
                (int) $quantity > 0
                && $storeSupplies->has($supplyId)
                && $storeSupplies->get($supplyId)->quantity > 0
            ) {
                $writeOffList[$supplyId] = min((int) $quantity, $storeSupplies->get($supplyId)->quantity);
            }
        }

        if (0 === count($writeOffList)) {
            return redirect()->route('stores.catalog', $store->id)->with('error', 'Пустой список списания товаров');
        }

        $popupText = 'Списаны товары:<br>';
        foreach ($writeOffList as $id => $quantity) {
            $ourSupply = $storeSupplies->get($id);
            $popupText .= $quantity . 'шт ' . $ourSupply->supplyInfo->name .  '<br>';

            $ourSupply->quantity -= $quantity;
            $ourSupply->save();
        }

        return redirect()->route('stores.catalog', $store->id)->with('success', $popupText);
    }
}
