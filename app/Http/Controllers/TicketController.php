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
        //
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
