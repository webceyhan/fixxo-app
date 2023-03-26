<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Http\Requests\SaveTicketRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedParams = request()->only('search', 'status');

        $tickets = Ticket::query()
            ->filterByParams($allowedParams)
            // ->withCount(['tasks'])
            // ->withSum('tasks as total_cost', 'price')
            ->with('device')
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Tickets/Index', [
            'tickets' => $tickets,
            'filters' => [
                'status' => TicketStatus::values(),
            ]
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
    public function store(SaveTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // TODO: improve this! only needed for aside card representation
        $ticket->load([
            'device',
            'customer',
            'user:id,name',
        ]);

        // append custom attributes
        $ticket->append([
            // 'cost',
            // 'balance',
            // 'balance_map',
            'qr_url',
            'uploaded_urls',
            // 'intake_signature_url',
            // 'delivery_signature_url',
        ]);

        return inertia('Tickets/Show', [
            'ticket' => $ticket,
            'customer' => $ticket->customer,
            'tasks' => $ticket->tasks()->with('user:id,name')->get(),
            //    'payments' => $ticket->payments()->with('user:id,name')->get(),
            //    'canDelete' => auth()->user()->can('delete', $ticket),
            // TODO: improve this!
            // we are checking for the ability to delete a task in the future
            // but at this point we don't have a task/payment yet so as a workaround
            // we are using a dummy new Task/Payment instance instead of Task::class
            //    'canDeleteTask' => auth()->user()->can('delete', new Task),
            //    'canDeletePayment' => auth()->user()->can('delete', new Payment),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
