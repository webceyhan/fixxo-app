<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
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
        // create tickets for all devices
        Device::all()->each(function (Device $device) {
            Ticket::factory()->forDevice($device)->create();
        });

        // get all active users
        $users = User::ofStatus(UserStatus::Active)->get();

        // create and assign tickets to random active users
        Device::all()->random(10)->each(function (Device $device) use ($users) {
            Ticket::factory()->forDevice($device)->forAssignee($users->random())->create();
        });
    }
}
