<?php

namespace Database\Seeders;

use App\Models\Asset;
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

        Asset::all()->each(function ($asset) use ($users) {

            $amount = rand(1, 2);

            Payment::factory($amount)->create([
                'asset_id' => fn () => $asset->id,
                'user_id' => fn () => $users->random(1)->first(),
            ]);
        });
    }
}
