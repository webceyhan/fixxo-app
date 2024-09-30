<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
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
        // Create a random number of tasks for each ticket.
        Ticket::all()->each(function (Ticket $ticket) {
            $amount = rand(0, 2);

            Task::factory($amount)->forTicket($ticket)->create();
        });

        // cancel some tasks
        Task::all()->random(5)->each(function (Task $task) {
            $task->status = TaskStatus::Cancelled;
            $task->save();
        });

        // complete some new tasks
        Task::ofStatus(TaskStatus::New)->get()->random(20)->each(function (Task $task) {
            $task->status = TaskStatus::Completed;
            $task->save();
        });
    }
}
