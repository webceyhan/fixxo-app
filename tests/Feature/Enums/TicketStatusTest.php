<?php

use App\Enums\TicketStatus;

it('has values', function () {
    expect(TicketStatus::values())->toBe([
        'new',
        'in_progress',
        'on_hold',
        'resolved',
        'closed',
    ]);
});

it('has completed cases', function () {
    expect(TicketStatus::completedCases())->toBe([
        TicketStatus::Resolved,
        TicketStatus::Closed,
    ]);
});

it('can determine if case is completed', function (TicketStatus $case, bool $expected) {
    expect($case->isCompleted())->toBe($expected);
})->with([
    [TicketStatus::New, false],
    [TicketStatus::InProgress, false],
    [TicketStatus::OnHold, false],
    [TicketStatus::Resolved, true],
    [TicketStatus::Closed, true]
]);
