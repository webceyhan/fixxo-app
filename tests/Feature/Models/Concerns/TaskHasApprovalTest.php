<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can determine if task is approved', function () {
    $task = Task::factory()->approved()->create();

    expect($task->isApproved())->toBeTrue();
    expect($task->approved_at)->toBeInstanceOf(Carbon::class);
});

it('can filter tasks by approved scope', function () {
    Task::factory()->create();
    Task::factory()->approved()->create();

    expect(Task::approved()->count())->toBe(1);
    expect(Task::approved()->first()->isApproved())->toBeTrue();
});
