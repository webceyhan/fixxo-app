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
        $allowedParams = request()->only('search', 'status');

        $orders = Order::query()
            ->filterByParams($allowedParams)
            // ->with('ticket.customer')
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'status' => OrderStatus::values(),
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
    public function store(SaveOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
