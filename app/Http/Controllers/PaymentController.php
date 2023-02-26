<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedParams = request()->only('search', 'type', 'method');

        $payments = Payment::query()
            ->filterByParams($allowedParams)
            ->with(['asset:id,name,customer_id', 'asset.customer:id,name', 'user:id,name'])
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Payments/Index', [
            'payments' => $payments,
            'filters' => [
                'type' => PaymentType::values(),
                'method' => PaymentMethod::values(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return inertia('Payments/Show', [
            'payment' => $payment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
