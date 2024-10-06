<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveInvoiceRequest;
use App\Models\Invoice;
use App\Queries\InvoiceQuery;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Invoices/Index', [
            'invoices' => (new InvoiceQuery)->paginate(),
            'filters' => InvoiceQuery::filters(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveInvoiceRequest $request)
    {
        return $this->update($request, new Invoice());
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return $this->edit($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return inertia('Invoices/Show', [
            'invoice' => $invoice,
            'ticket' => $invoice->ticket
                ->append(['qr_url'])
                ->load([
                    'device',
                    'customer',
                    'assignee:id,name',
                ]),
            'canDelete' => Gate::allows('delete', $invoice),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveInvoiceRequest $request, Invoice $invoice)
    {
        $params = $request->validated();

        $invoice->fill($params)->save();

        return redirect()
            ->route('tickets.show', $invoice->ticket_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        Gate::authorize('delete', $invoice);

        $invoice->delete();

        return redirect()
            ->route('tickets.show', $invoice->ticket_id)
            ->with('status', __('record deleted'));
    }
}
