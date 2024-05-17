<?php

use App\Enums\Interval;
use Illuminate\Support\Carbon;

beforeEach(function () {
    Carbon::setTestNow('2021-01-01 00:00:00');
});

it('has values', function () {
    expect(Interval::values())->toBe([
        'day',
        'week',
        'month',
        'year',
    ]);
});

it('can convert to date', function (Interval $case, Carbon $expected) {
    expect($case->toDate()->toDateString())->toBe($expected->toDateString());
})->with([
    [Interval::Day, fn () => Carbon::today()->subDay()],
    [Interval::Week, fn () => Carbon::today()->subWeek()],
    [Interval::Month, fn () => Carbon::today()->subMonth()],
    [Interval::Year, fn () => Carbon::today()->subYear()],
]);

it('can convert to date formatter', function (Interval $case, callable $expected) {
    expect($case->toDateFormatter()(12))->toBe($expected(12));
})->with([
    [Interval::Day, fn ($date) => Carbon::today()->setTime($date, 0, 0)->format('H:i')],
    [Interval::Week, fn ($date) => Carbon::today()->day($date)->format('D')],
    [Interval::Month, fn ($date) => Carbon::today()->week($date)->format('d M')],
    [Interval::Year, fn ($date) => Carbon::today()->month($date)->format('M')],
]);

it('can convert to SQL function', function (Interval $case, string $expected) {
    expect($case->toSqlFunction())->toBe($expected);
})->with([
    [Interval::Day, 'hour'],
    [Interval::Week, 'day'],
    [Interval::Month, 'week'],
    [Interval::Year, 'month'],
]);

it('has options', function () {
    expect(Interval::options())->toBe([
        'day' => 'Today',
        'week' => 'This Week',
        'month' => 'This Month',
        'year' => 'This Year',
    ]);
});
