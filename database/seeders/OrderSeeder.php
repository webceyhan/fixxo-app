<?php

namespace Database\Seeders;

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
        Ticket::all()->each(function ($ticket) {

            $amount = rand(0, 2);

            Order::factory($amount)->create([
                'ticket_id' => fn () => $ticket->id,
            ]);
        });
    }
}
