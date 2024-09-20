<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReturnController
{
    public function index(): View
    {
        return view('return.return');
    }

    public function store(CustomerCreateRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        return redirect()->route('customers.index');
    }
}
