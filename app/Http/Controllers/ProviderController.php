<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Provider\ProviderCreateRequest;
use App\Http\Requests\Provider\ProviderUpdateRequest;
use App\Models\Provider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProviderController
{
    public function index(): View
    {
        $providers = Provider::all();

        return view('provider.index', [
            'providers' => $providers,
        ]);
    }

    public function create(): View
    {
        return view('provider.create');
    }

    public function store(ProviderCreateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Provider::create($data);

        return redirect()->route('provider.index');
    }

    public function edit(Provider $provider): View
    {
        return view('provider.edit', [
            'provider' => $provider,
        ]);
    }


    public function update(Provider $provider, ProviderUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $provider->update($data);

        return redirect()->route('provider.index');
    }

    public function destroy(Provider $provider): RedirectResponse
    {
        $provider->delete();

        return redirect()->route('provider.index');
    }

}
