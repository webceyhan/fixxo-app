<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use App\Http\Requests\SavePaymentRequest;
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
            ->with([
                'ticket:id,name,customer_id',
                'ticket.customer:id,name',
                'user:id,name'
            ])
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
        return $this->edit(new Payment(
            request()->only('ticket_id')
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePaymentRequest $request)
    {
        return $this->update($request, new Payment());
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        // forward to edit page
        return $this->edit($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        // TODO: improve this! 
        // only for aside card representation
        $payment->load('ticket.customer:id,name');

        return inertia('Payments/Edit', [
            'payment' => $payment,
            'typeOptions' => PaymentType::values(),
            'methodOptions' => PaymentMethod::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePaymentRequest $request, Payment $payment)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $payment->fill($params)->save();

        return redirect()
            ->route('tickets.show', $payment->ticket_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // TODO: use athorizeResource() here, see UserController::__construct()
        $this->authorize('delete', $payment);

        $payment->delete();

        return redirect()
            ->route('tickets.show', $payment->ticket_id)
            ->with('status', __('record deleted'));
    }
}
