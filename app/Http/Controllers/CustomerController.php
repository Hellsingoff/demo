<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController
{
    public function index(): View
    {
        $customers = Customer::all();

        return view('customer.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customer.create');
    }

    public function store(CustomerCreateRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer): View
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Customer $customer, CustomerUpdateRequest $request): RedirectResponse
    {
        $customer->update($request->validated());

        return redirect()->route('customers.index');
    }
}
