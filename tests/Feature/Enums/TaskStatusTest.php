<?php

use App\Enums\TaskStatus;

it('has values', function () {
    expect(TaskStatus::values())->toBe([
        'new',
        'completed',
        'cancelled',
    ]);
});

it('has completed cases', function () {
    expect(TaskStatus::completedCases())->toBe([
        TaskStatus::Completed,
        TaskStatus::Cancelled,
    ]);
});

it('can determine if case is completed', function (TaskStatus $case, bool $expected) {
    expect($case->isCompleted())->toBe($expected);
})->with([
    [TaskStatus::New, false],
    [TaskStatus::Completed, true],
    [TaskStatus::Cancelled, true]
]);
