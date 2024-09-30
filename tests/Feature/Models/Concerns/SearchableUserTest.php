<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // searchable colunms: name, email, phone

    User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john.doe@mail.com',
        'phone' => '4891234567',
    ]);

    User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane.doe@yahoo.com',
        'phone' => '0987654321',
    ]);

    User::factory()->create([
        'name' => 'Johnny Appleseed',
        'email' => 'johnny@gmail.com',
        'phone' => '1234567890',
    ]);

    User::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane.smith@web.com',
        'phone' => '1234555666777',
    ]);

    // FULLTEXT indexes don't work in transactions: https://dev.mysql.com/doc/refman/en/innodb-fulltext-index.html#innodb-fulltext-index-transaction
    // If you want to use RefreshDatabase, you have to commit the transaction and then clean up the database yourself:
    DB::commit();
});

afterEach(function () {
    DB::table('users')->delete();
});

describe('scopes', function () {
    it('can filter users by search scope', function (string $keyword, int $expectedCount) {
        $users = User::search($keyword)->get();

        expect($users->count())->toBe($expectedCount);
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
    ]);
});


