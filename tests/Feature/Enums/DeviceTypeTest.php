<?php

use App\Enums\DeviceType;

it('has values', function () {
    expect(DeviceType::values())->toBe([
        'phone',
        'tablet',
        'laptop',
        'desktop',
        'other',
    ]);
});
