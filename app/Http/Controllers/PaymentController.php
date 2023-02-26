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
        $payments = Payment::query()
            ->when(request('type'), fn ($query, $type) => $query->where('type', $type))
            ->when(request('method'), fn ($query, $method) => $query->where('method', $method))
            ->when(request('search'),  fn ($query, $search) => $query->where('notes', 'like', "%{$search}%"))
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
