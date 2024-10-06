<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can determine if order is approved', function () {
    $order = Order::factory()->approved()->create();

    expect($order->isApproved())->toBeTrue();
    expect($order->approved_at)->toBeInstanceOf(Carbon::class);
});

it('can filter orders by approved scope', function () {
    Order::factory()->create();
    Order::factory()->approved()->create();

    expect(Order::approved()->count())->toBe(1);
    expect(Order::approved()->first()->isApproved())->toBeTrue();
});
