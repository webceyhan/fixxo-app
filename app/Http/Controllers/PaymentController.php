<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePaymentRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePaymentRequest $request)
    {
        return $this->update($request, new Payment());
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
