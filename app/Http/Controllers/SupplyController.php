<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Supply\SupplyInfoCreateRequest;
use App\Http\Requests\Supply\SupplyInfoUpdateRequest;
use App\Models\Provider;
use App\Models\SupplyInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplyController
{
    public function index(): View
    {
        $supplies = SupplyInfo::all();

        $preparedList = [];

        foreach ($supplies as $item) {
            $preparedList[] = [
                'name' => $item->name,
                'price' => $item->price,
                'description' => $item->description,
                'id' => $item->id,
            ];
        }

        return view('supply.index', [
            'supplyList' => $preparedList,
        ]);
    }

    public function edit(SupplyInfo $supply): View
    {
        $providers = Provider::all();

        return view('supply.edit', [
            'supply' => $supply,
            'providers' => $providers,
            'supplyProviders' => $supply->providers()->pluck('providers.id')->toArray(),
        ]);
    }

    public function create(): View
    {
        $providers = Provider::all();

        return view('supply.create',
        [
            'providers' => $providers,
        ]);

    }

    public function store(SupplyInfoCreateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $supply = SupplyInfo::create($data);
        $supply->providers()->sync($data['providers']);

        return redirect()->route('supplies.index');
    }

    public function update(SupplyInfo $supply, SupplyInfoUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $supply->update($data);
        $supply->providers()->sync($data['providers']);

        return redirect()->route('supplies.index');
    }

    public function destroy(SupplyInfo $supply): RedirectResponse
    {
        if (0 !== $supply->stocks()->sum('quantity')) {
            return redirect()->route('supplies.index')->with('error', 'Невозможно удалить товар, так как есть остатки на складе.');
        }
        $supply->providers()->sync([]);
        $supply->delete();

        return redirect()->route('supplies.index')->with('success', 'Товар успешно удален.');
    }
}
