<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

beforeEach(function () {

    // searchable colunms: description

    Ticket::factory()->create([
        'description' => 'Broken screen and battery needs to be replaced',
    ]);

    Ticket::factory()->create([
        'description' => 'iPhone 13 Pro Max is not turning on',
    ]);

    Ticket::factory()->create([
        'description' => 'Samsung Galaxy Note 20 Ultra needs a new battery',
    ]);

    Ticket::factory()->create([
        'description' => 'Sony Xperia 1 III has a broken camera',
    ]);

    // FULLTEXT indexes don't work in transactions: https://dev.mysql.com/doc/refman/en/innodb-fulltext-index.html#innodb-fulltext-index-transaction
    // If you want to use RefreshDatabase, you have to commit the transaction and then clean up the database yourself:
    DB::commit();
});

afterEach(function () {
    DB::table('tickets')->delete();
    DB::table('devices')->delete();
    DB::table('customers')->delete();
});

describe('scopes', function () {
    it('can filter tickets by search scope', function (string $keyword, int $expectedCount) {
        $tickets = Ticket::search($keyword)->get();

        expect($tickets->count())->toBe($expectedCount);
    })->with([
        ['iphone pro', 1],
        ['samsung galaxy', 1],
        ['sony xperia', 1],
        ['broken screen', 2],
        ['camera broken', 2],
        ['battery replacement', 2],
        ['screen replacement', 1],
    ]);
});
