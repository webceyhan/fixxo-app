<?php

namespace Database\Seeders;

use App\Models\Invoice;
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
        Invoice::all()->random(20)->each(function ($invoice) {
            // total balance to pay
            $balance = abs($invoice->balance);

            // make 10% discount if balance is more than $100
            if ($balance >= 100) {
                Transaction::factory()->forInvoice($invoice)->discount()->create([
                    'amount' => $balance * 0.1,
                ]);

                // update balance
                $balance -= ($balance * 0.1);
            }

            // pay the rest if balance is more than $0
            if ($balance > 0) {
                Transaction::factory()->forInvoice($invoice)->create([
                    'amount' => $balance,
                ]);
            }
        });
    }
}
