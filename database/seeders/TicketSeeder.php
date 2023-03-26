<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Device::all()->each(function ($device) use ($users) {

            $amount = rand(1, 3);

            Ticket::factory($amount)->create([
                'device_id' => fn () => $device->id,
                'user_id' => fn () => $users->random(1)->first(),
                // create date must be later than device creation
                // 'created_at' => fn () => fake()->dateTimeBetween($device->created_at),
            ]);
        });
    }
}
