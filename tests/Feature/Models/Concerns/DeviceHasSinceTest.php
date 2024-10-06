<?php

use App\Enums\Interval;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->actingAs(User::factory()->create());

    // Tuesday February 20, 2024
    Carbon::setTestNow('2024-02-20 00:00:00');
});

describe('scopes', function () {
    beforeEach(function () {
        collect([
            '2024-02-20', // today
            '2024-02-19', // this week
            '2024-02-13', // this month
            '2024-01-20', // this year
            '2023-02-20', // last year
        ])->each(function ($date) {
            Device::factory()->create(['created_at' => now()->parse($date)]);
        });
    });

    it('can filter tasks by sinceToday scope', function () {
        expect(Device::sinceToday()->count())->toBe(1);
    });

    it('can filter tasks by sinceThisWeek scope', function () {
        expect(Device::sinceThisWeek()->count())->toBe(2);
    });

    it('can filter tasks by sinceThisMonth scope', function () {
        expect(Device::sinceThisMonth()->count())->toBe(3);
    });

    it('can filter tasks by sinceThisYear scope', function () {
        expect(Device::since(Interval::Year)->count())->toBe(4);
    });
});