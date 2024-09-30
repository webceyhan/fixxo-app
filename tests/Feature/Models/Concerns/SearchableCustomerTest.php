<?php

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

beforeEach(function () {

    // searchable colunms: name, company, phone, email, address

    Customer::factory()->create([
        'name' => 'John Doe',
        'company' => 'Apple Inc.',
        'email' => 'john.doe@mail.com',
        'phone' => '4891234567',
        'address' => '1234 New Hempshire St.',
    ]);

    Customer::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane.doe@yahoo.com',
        'phone' => '0987654321',
        'address' => '1234 Elm St.',
    ]);

    Customer::factory()->create([
        'name' => 'Johnny Appleseed',
        'email' => 'johnny@gmail.com',
        'phone' => '1234567890',
    ]);

    Customer::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane.smith@web.com',
        'phone' => '1234555666777',
    ]);

    // FULLTEXT indexes don't work in transactions: https://dev.mysql.com/doc/refman/en/innodb-fulltext-index.html#innodb-fulltext-index-transaction
    // If you want to use RefreshDatabase, you have to commit the transaction and then clean up the database yourself:
    DB::commit();
});

afterEach(function () {
    DB::table('customers')->delete();
});

describe('scopes', function () {
    it('can filter customers by search scope', function (string $keyword, int $expectedCount) {
        $customers = Customer::search($keyword)->get();

        expect($customers->count())->toBe($expectedCount);
    })->with([
        ['john doe', 3],
        ['johnny', 1],
        ['john', 2],
        ['jane', 2],
        ['doe', 2],
        ['appleseed', 1],
        ['mail.com', 1],
        ['gmail.com', 1],
        ['12345', 2],
        ['123456', 1],
        ['apple inc.', 2],
        ['new hempshire', 1],
    ]);
});
