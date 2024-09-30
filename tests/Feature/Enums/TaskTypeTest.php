<?php

use App\Enums\TaskType;

it('has values', function () {
    expect(TaskType::values())->toBe([
        'repair',
        'maintenance',
        'installation',
        'inspection',
        'upgrade',
        'other',
    ]);
});
