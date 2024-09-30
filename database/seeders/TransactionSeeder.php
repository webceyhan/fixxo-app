<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::completed()->each(function ($ticket) {
            // total balance to pay
            $balance = abs($ticket->balance);

            // make 10% discount if balance is more than $100
            if ($balance >= 100) {
                Transaction::factory()->forTicket($ticket)->discount()->create([
                    'amount' => $balance * 0.1,
                ]);

                // update balance
                $balance -= ($balance * 0.1);
            }

            // pay the rest if balance is more than $0
            if ($balance > 0) {
                Transaction::factory()->forTicket($ticket)->create([
                    'amount' => $balance,
                ]);
            }
        });
    }
}
