<?php

namespace App\Http\Controllers;

use App\Enums\TicketStatus;
use App\Http\Requests\SaveTicketRequest;
use App\Models\Device;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\Ticket;
use App\Queries\TicketQuery;
use App\Services\NotificationService;
use App\Services\SignatureService;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Tickets/Index', [
            'tickets' => (new TicketQuery)->paginate(),
            'filters' => TicketQuery::filters(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // fetch device to fill in customer_id
        $device = Device::findOrFail(request('device_id'));

        return $this->edit(new Ticket([
            'device_id' => $device->id,
            'customer_id' => $device->customer_id,

        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveTicketRequest $request)
    {
        return $this->update($request, new Ticket());
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
            'tasks_cost',
            'orders_cost',
            'cost',
            'paid',
            'qr_url',
            'uploaded_urls',
            'intake_signature_url',
            'delivery_signature_url',
        ]);

        return inertia('Tickets/Show', [
            'ticket' => $ticket,
            'customer' => $ticket->customer,
            'tasks' => $ticket->tasks()->with('user:id,name')->get(),
            'orders' => $ticket->orders()->with('user:id,name')->get(),
            'transactions' => $ticket->transactions()->with('user:id,name')->get(),
            'canDelete' => Gate::allows('delete', $ticket),
            // TODO: improve this!
            // we are checking for the ability to delete a task in the future
            // but at this point we don't have a task/transaction yet so as a workaround
            // we are using a dummy new Task/Transaction instance instead of Task::class
            'canDeleteTask' => Gate::allows('delete', new Task),
            'canDeleteOrder' => Gate::allows('delete', new Order),
            'canDeleteTransaction' => Gate::allows('delete', new Transaction),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // TODO: improve this! only needed for aside card representation
        $ticket->load(['device', 'customer']);

        return inertia('Tickets/Edit', [
            'ticket' => $ticket,
            'statusOptions' => TicketStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTicketRequest $request, Ticket $ticket)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $ticket->fill($params)->save();

        // check if status is ready for pickup
        if ($ticket->status == TicketStatus::Resolved) {

            // send SMS to customer if phone number is provided
            if ($ticket->customer->phone !== null) {
                $phone = $ticket->customer->phone;
                $message = __('Your device is ready for pickup.');

                try { // try to send SMS or skip
                    NotificationService::sendSMS($phone, $message);
                } catch (\Throwable $e) {
                    // TODO: log error
                }
            }
        }

        return redirect()
            ->route('tickets.show', $ticket->id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('status', __('record deleted'));
    }

    /**
     * Add signature to the specified ticket.
     */
    public function sign(Ticket $ticket)
    {
        $type = request()->input('type');
        $blob = request()->input('blob');

        // TODO: see related Ticket model attribute
        SignatureService::put("{$ticket->id}-{$type}", $blob);

        return redirect()->back();
    }
}
