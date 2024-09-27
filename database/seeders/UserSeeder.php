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
        // add active admin
        User::factory()->admin()->create([
            'name' => 'Admin John',
            'email' => 'admin@demo.com',
            'created_at' => now()->subMonths(6),
        ]);

        // add active manager
        User::factory()->manager()->create([
            'name' => 'Manager Jane',
            'email' => 'manager@demo.com',
            'created_at' => now()->subMonths(5),
        ]);

        // add active technician
        User::factory()->create([
            'name' => 'Technician Doe',
            'email' => 'technician@demo.com',
            'created_at' => now()->subMonths(4)
        ]);

        // create random technicians for each status
        UserStatus::all()->each(function (UserStatus $status) {
            User::factory(5)->ofStatus($status)->create([
                'created_at' => fn() => now()->subMonths(rand(1, 3)),
            ]);
        });
    }
}
