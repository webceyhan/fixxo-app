<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        User::factory()->admin()->create([
            'name' => 'Admin John',
            'email' => 'admin@demo.com',
        ]);

        // manager
        User::factory()->manager()->create([
            'name' => 'Manager Jane',
            'email' => 'manager@demo.com',
        ]);

        // technician
        User::factory()->create([
            'name' => 'Technician Doe',
            'email' => 'technician@demo.com',
        ]);

        // technicians with different status
        UserStatus::all()->each(function (UserStatus $status) {
            User::factory(3)->ofStatus($status)->create();
        });

        // technician without phone
        User::factory(2)->withoutPhone()->create();
    }
}
