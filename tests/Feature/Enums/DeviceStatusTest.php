<?php

use App\Enums\DeviceStatus;

it('has values', function () {
    expect(DeviceStatus::values())->toBe([
        'checked_in',
        'on_hold',
        'in_repair',
        'finished',
        'checked_out',
    ]);
});

it('has completed cases', function () {
    expect(DeviceStatus::completedCases())->toBe([
        DeviceStatus::Finished,
        DeviceStatus::CheckedOut,
    ]);
});

it('can determine if case is completed', function (DeviceStatus $case, bool $expected) {
    expect($case->isCompleted())->toBe($expected);
})->with([
    [DeviceStatus::CheckedIn, false],
    [DeviceStatus::OnHold, false],
    [DeviceStatus::InRepair, false],
    [DeviceStatus::Finished, true],
    [DeviceStatus::CheckedOut, true]
]);
