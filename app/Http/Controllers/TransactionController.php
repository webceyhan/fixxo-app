<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTransactionRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveTransactionRequest $request)
    {
        return $this->update($request, new Transaction());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTransactionRequest $request, Transaction $transaction)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $transaction->fill($params)->save();

        return redirect()
            ->route('tickets.show', $transaction->ticket_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // TODO: use athorizeResource() here, see UserController::__construct()
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('tickets.show', $transaction->ticket_id)
            ->with('status', __('record deleted'));
    }
}
