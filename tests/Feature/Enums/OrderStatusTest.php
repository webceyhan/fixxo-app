<?php

use App\Enums\OrderStatus;

it('has values', function () {
    expect(OrderStatus::values())->toBe([
        'new',
        'shipped',
        'received',
        'cancelled',
    ]);
});

it('has completed cases', function () {
    expect(OrderStatus::completedCases())->toBe([
        OrderStatus::Received,
        OrderStatus::Cancelled,
    ]);
});

it('can determine if case is completed', function (OrderStatus $case, bool $expected) {
    expect($case->isCompleted())->toBe($expected);
})->with([
    [OrderStatus::New, false],
    [OrderStatus::Shipped, false],
    [OrderStatus::Received, true],
    [OrderStatus::Cancelled, true]
]);
