<?php

use App\Enums\TransactionMethod;

it('has values', function () {
    expect(TransactionMethod::values())->toBe([
        'cash',
        'card',
        'online',
    ]);
});
