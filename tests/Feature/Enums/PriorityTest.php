<?php

use App\Enums\Priority;

it('has values', function () {
    expect(Priority::values())->toBe([
        'low',
        'normal',
        'high',
    ]);
});
