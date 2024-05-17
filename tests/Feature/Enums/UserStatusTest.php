<?php

use App\Enums\UserStatus;

it('has values', function () {
    expect(UserStatus::values())->toBe([
        'active',
        'on_leave',
        'suspended',
        'terminated',
    ]);
});

it('can determine if case is active', function (UserStatus $case, bool $expected) {
    expect($case->isActive())->toBe($expected);
})->with([
    [UserStatus::Active, true],
    [UserStatus::OnLeave, false],
    [UserStatus::Suspended, false],
    [UserStatus::Terminated, false]
]);
