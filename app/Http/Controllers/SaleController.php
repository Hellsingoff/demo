<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\PaymentMethodEnum;
use App\Enum\SaleStatusEnum;
use App\Enum\StoreTypeEnum;
use App\Http\Requests\Position\PositionCreateRequest;
use App\Http\Requests\Sale\SaleCompleteRequest;
use App\Models\CheckPosition;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SaleController
{
    /**
     * @param string[] $relations
     */
    private function getActiveSale(User $user, array $relations = []): Sale
    {
        $sale = Sale::with($relations)
            ->where([
                'user_id' => $user->id,
                'status' => SaleStatusEnum::New
            ])
            ->first();

        if (null === $sale) {
            $sale = Sale::create([
                'user_id' => $user->id,
                'status' => SaleStatusEnum::New,
                'payment_method' => PaymentMethodEnum::Card,
                'store_id' => $user->store_id,
            ]);
        }

        return $sale;
    }

    public function active(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $sale = $this->getActiveSale($user, ['positions', 'positions.supplyInfo']);

        $positions = [];
        $sumPrice = 0;
        foreach ($sale->positions as $position) {
            $positions[$position->id] = [
                'name' => $position->supplyInfo->name,
                'quantity' => $position->quantity,
                'price' => $position->supplyInfo->price * $position->quantity,
            ];
            $sumPrice += $position->supplyInfo->price * $position->quantity;
        }

        if ($user->store->type !== StoreTypeEnum::Minimarket) {
            $customers = Customer::all()->mapWithKeys(static function (Customer $customer) {
                return [$customer->id => "$customer->name, $customer->number_card"];
            })->toArray();
        }

        return view('sale.sale', [
            'store' => $user->store->name,
            'positions' => $positions,
            'storeType' => $user->store->type->value,
            'customers' => $customers ?? [],
            'sumPrice' => $sumPrice,
        ]);
    }

    public function storePosition(PositionCreateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $sale = $this->getActiveSale($user);
        $barcode = $request->validated()['barcode'];
        $supply = Supply::with('supplyInfo')
            ->whereHas('supplyInfo', static function ($query) use ($barcode): void {
                $query->where('barcode', $barcode);
            })
            ->where('store_id', $user->store_id)
            ->first();

        if (null === $supply || 0 === $supply->quantity) {
            return redirect()->route('sales.active')->with('error', 'Данного товара нет в наличии в магазине');
        }

        $supply->quantity -= 1;
        $supply->save();

        $position = $sale->positions->firstWhere('supply_info_id', $supply->supply_info_id);
        if (null === $position) {
            CheckPosition::create([
                'sale_id' => $sale->id,
                'supply_info_id' => $supply->supply_info_id,
                'quantity' => 1,
            ]);
        } else {
            $position->quantity += 1;
            $position->save();
        }

        return redirect()->route('sales.active');
    }

    public function complete(SaleCompleteRequest $request): RedirectResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $sale = $this->getActiveSale($user);
        if (0 === $sale->positions()->count()) {
            return redirect()->route('sales.active')->with('error', 'Нельзя оплатить пустой список товаров');
        }

        $sale->status = SaleStatusEnum::Paid;
        $sale->payment_method = PaymentMethodEnum::from($data['payment_method']);
        $sale->customer_id = $data['customer_id'] ?? null;
        $sale->save();

        return redirect()->route('main.menu');
    }

    public function revertSupplyToStore(int $storeId, int $supplyInfoId, int $quantity): void
    {
        $supply = Supply::where('store_id', $storeId)
            ->where(['supply_info_id' => $supplyInfoId])
            ->first();
        if (null !== $supply) {
            $supply->quantity += $quantity;
            $supply->save();
        } else {
            Supply::create([
                'supply_info_id' => $supplyInfoId,
                'quantity' => $quantity,
                'store_id' => $storeId,
            ]);
        }
    }

    public function destroyPosition(CheckPosition $position): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->id !== $position->sale->user_id) {
            return redirect()->route('sales.active')->with('error', 'Нельзя удалить товар из чужого чека');
        }

        $this->revertSupplyToStore($user->store_id, $position->supply_info_id, $position->quantity);
        $position->delete();

        return redirect()->route('sales.active');
    }

    public function destroy(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $sale = $this->getActiveSale($user, ['positions']);
        foreach ($sale->positions as $position) {
            $this->revertSupplyToStore($user->store_id, $position->supply_info_id, $position->quantity);
            $position->delete();
        }

        return redirect()->route('sales.active');
    }
}
