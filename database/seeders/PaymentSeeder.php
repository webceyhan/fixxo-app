<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Ticket::all()->each(function ($ticket) use ($users) {

            $amount = rand(1, 3);

            Payment::factory($amount)->create([
                'ticket_id' => fn () => $ticket->id,
                'user_id' => fn () => $users->random(1)->first(),
            ]);
        });
    }
}
