<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Ticket;
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

        Ticket::all()->each(function ($ticket) use ($users) {

            // create optional tasks
            $amount = rand(0, 5);

            Task::factory($amount)->create([
                'ticket_id' => fn () => $ticket->id,
                'user_id' => fn () => $users->random(1)->first(),
                // create date must be later than ticket creation
                'created_at' => fn () => fake()->dateTimeBetween($ticket->created_at),
                'completed_at' => fn () => fake()->optional()->dateTimeBetween($ticket->created_at),
            ]);
        });
    }
}
