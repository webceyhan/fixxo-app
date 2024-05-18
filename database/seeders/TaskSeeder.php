<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::all()->each(function ($ticket) {
            // create optional tasks
            $amount = rand(0, 5);

            Task::factory($amount)->create([
                'ticket_id' => fn () => $ticket->id,
                // create date must be later than ticket creation
                'created_at' => fn () => fake()->dateTimeBetween($ticket->created_at),
            ]);
        });
    }
}
