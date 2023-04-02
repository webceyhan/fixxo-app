<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\SaveOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()
            ->filter(request()->all())
            ->search(request()->input('search'))
            ->with('ticket.device', 'ticket.customer')
            ->latest('id')
            ->paginate();

        return inertia('Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'status' => OrderStatus::values(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveOrderRequest $request)
    {
        return $this->update($request, new Order());
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $this->edit($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return inertia('Orders/Show', [
            'order' => $order,
            'ticket' => $order->ticket
                ->append(['qr_url'])
                ->load([
                    'device',
                    'customer',
                    'user:id,name',
                ]),
            'canDelete' => auth()->user()->can('delete', $order),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveOrderRequest $request, Order $order)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $order->fill($params)->save();

        return redirect()
            ->route('tickets.show', $order->ticket_id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // TODO: use athorizeResource() here, see UserController::__construct()
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()
            ->route('tickets.show', $order->ticket_id)
            ->with('status', __('record deleted'));
    }
}
