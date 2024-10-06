<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create orders for random tickets
        Ticket::all()->random(30)->each(function (Ticket $ticket) {
            // create normal order
            Order::factory()->forTicket($ticket)->create();

            // create pre-approved order
            Order::factory()->forTicket($ticket)->approved()->create();
        });

        // cancel some orders
        Order::all()->random(5)->each(function (Order $order) {
            $order->status = OrderStatus::Cancelled;
            $order->save();
        });

        // ship some new orders
        Order::ofStatus(OrderStatus::New)->get()->random(20)->each(function (Order $order) {
            $order->status = OrderStatus::Shipped;
            $order->save();
        });

        // receive some shipped orders
        Order::ofStatus(OrderStatus::Shipped)->get()->random(10)->each(function (Order $order) {
            $order->status = OrderStatus::Received;
            $order->save();
        });
    }
}
