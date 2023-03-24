<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Asset::all()->each(function ($asset) use ($users) {

            $amount = rand(1, 5);

            Task::factory($amount)->create([
                'asset_id' => fn () => $asset->id,
                'user_id' => fn () => $users->random(1)->first(),
            ]);
        });
    }
}
