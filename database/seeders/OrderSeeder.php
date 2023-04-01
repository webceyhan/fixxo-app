<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Ticket::all()->each(function ($ticket) use ($users) {

            $amount = rand(0, 2);

            Order::factory($amount)->create([
                'ticket_id' => fn () => $ticket->id,
                'user_id' => fn () => $users->random(1)->first(),
            ]);
        });
    }
}
