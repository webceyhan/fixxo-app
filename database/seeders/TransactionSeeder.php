<?php

namespace Database\Seeders;

use App\Enums\TransactionType;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Ticket::resolved()->each(function ($ticket) use ($users) {
            // total balance to pay
            $balance = abs($ticket->balance);

            $userId = $users->random(1)->first()->id;
            $timestamp = fake()->dateTimeBetween($ticket->created_at);

            // make 10% discount if balance is more than $100
            if ($balance >= 100) {
                Transaction::factory()->discount()->create([
                    'ticket_id' => fn () => $ticket->id,
                    'user_id' => fn () => $userId,
                    'amount' => fn () => $balance * 0.1,
                    'created_at' => fn () => $timestamp,
                ]);
                // update balance
                $balance -= ($balance * 0.1);
            }

            // pay the rest if balance is more than $0
            if ($balance > 0) {
                Transaction::factory()->payment()->create([
                    'ticket_id' => fn () => $ticket->id,
                    'user_id' => fn () => $userId,
                    'amount' => fn () => $balance,
                    'created_at' => fn () => $timestamp,
                ]);
            }
        });
    }
}
