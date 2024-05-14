<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Http\Requests\SaveCustomerRequest;
use App\Models\Customer;
use App\Queries\CustomerQuery;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Customers/Index', [
            'customers' => (new CustomerQuery)->paginate(),
            'filters' => CustomerQuery::filters(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new Customer());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveCustomerRequest $request)
    {
        return $this->update($request, new Customer());
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return inertia('Customers/Show', [
            'customer' => $customer,
            'devices' => $customer->devices()->get(),
            'tickets' => $customer->tickets()->get(),
            'canDelete' => auth()->user()->can('delete', $customer),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return inertia('Customers/Edit', [
            'customer' => $customer,
            'statusOptions' => UserStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveCustomerRequest $request, Customer $customer)
    {
        $params = $request->validated();

        $customer->fill($params)->save();

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        Gate::authorize('delete', $customer);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('status', __('record deleted'));
    }
}
