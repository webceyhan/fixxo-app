<?php

use App\Enums\TransactionType;

it('has values', function () {
    expect(TransactionType::values())->toBe([
        'payment',
        'discount',
        'warranty',
        'refund',
    ]);
});
