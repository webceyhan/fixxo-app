<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

beforeEach(function () {

    $this->actingAs(User::factory()->create());
    
    // searchable colunms: name, url

    Order::factory()->create([
        'name' => 'iPhone 12 Screen Replacement',
        'url' => 'https://www.example.com/iphone-12-screen-replacement',
    ]);

    Order::factory()->create([
        'name' => 'Samsung Galaxy S20 Battery',
        'url' => 'https://www.example.com/samsung-galaxy-s20-battery',
    ]);

    Order::factory()->create([
        'name' => 'iPhone XR Charging Port',
        'url' => 'https://www.example.com/iphone-xr-charging-port',
    ]);

    Order::factory()->create([
        'name' => 'Google Pixel 5 Camera Replacement',
        'url' => 'https://www.example.com/google-pixel-5-camera',
    ]);

    // FULLTEXT indexes don't work in transactions: https://dev.mysql.com/doc/refman/en/innodb-fulltext-index.html#innodb-fulltext-index-transaction
    // If you want to use RefreshDatabase, you have to commit the transaction and then clean up the database yourself:
    DB::commit();
});

afterEach(function () {
    DB::table('orders')->delete();
    DB::table('tickets')->delete();
    DB::table('devices')->delete();
    DB::table('customers')->delete();
    DB::table('users')->delete();
});

describe('scopes', function () {
    it('can filter orders by search scope', function (string $keyword, int $expectedCount) {
        $orders = Order::search($keyword)->get();

        expect($orders->count())->toBe($expectedCount);
    })->with([
        ['iphone 12', 2],
        ['samsung galaxy', 1],
        ['google pixel', 1],
        ['screen', 1],
        ['battery', 1],
        ['charging port', 1],
        ['camera', 1],
        ['screen & camera replacement', 2],
    ]);
});
