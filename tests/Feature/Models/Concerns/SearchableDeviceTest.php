<?php

use App\Models\Device;
use Illuminate\Support\Facades\DB;

beforeEach(function () {

    // searchable colunms: model, brand, serial_number

    Device::factory()->create([
        'model' => 'iPhone 12',
        'brand' => 'Apple Inc.',
        'serial_number' => '1234567890',
    ]);

    Device::factory()->create([
        'model' => 'iPhone 11',
        'brand' => 'Apple Inc.',
        'serial_number' => '0987654321',
    ]);

    Device::factory()->create([
        'model' => 'Galaxy S21',
        'brand' => 'Samsung',
    ]);

    Device::factory()->create([
        'model' => 'PlayStation 5',
        'brand' => 'Sony',
    ]);

    // FULLTEXT indexes don't work in transactions: https://dev.mysql.com/doc/refman/en/innodb-fulltext-index.html#innodb-fulltext-index-transaction
    // If you want to use RefreshDatabase, you have to commit the transaction and then clean up the database yourself:
    DB::commit();
});

afterEach(function () {
    DB::table('devices')->delete();
    DB::table('customers')->delete();
});

describe('scopes', function () {
    it('can filter devices by search scope', function (string $keyword, int $expectedCount) {
        $devices = Device::search($keyword)->get();

        expect($devices->count())->toBe($expectedCount);
    })->with([
        ['iphone', 2],
        ['iphone 13', 2],
        ['apple', 2],
        ['galaxy note', 1],
        ['samsung', 1],
        ['sony', 1],
        ['0987654321', 1],
    ]);
});
