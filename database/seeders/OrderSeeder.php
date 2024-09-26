<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    const PARTS = [
        'Dell XPS 13 Battery',
        'MacBook Pro Retina Screen',
        'Lenovo ThinkPad Keyboard',
        'HP Envy Touchpad',
        'Intel Core i7-10700K CPU',
        'ASUS ROG Strix Z490-E Motherboard',
        'Corsair Vengeance 16GB DDR4 RAM',
        'Western Digital 1TB SSD',
        'EVGA 600W Power Supply',
        'NVIDIA GeForce GTX 1660 Super Graphics Card',
        'iPhone 12 Screen Replacement',
        'Samsung Galaxy S20 Battery',
        'iPhone XR Charging Port',
        'Google Pixel 5 Camera',
        'iPad Pro 11" Screen',
        'Samsung Galaxy Tab S6 Battery',
        'iPad Air Charging Port',
        'Microsoft Surface Pro Camera',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::all()->random(10)->each(function (Ticket $ticket) {
            Order::factory()->forTicket($ticket)->create([
                'name' => fake()->randomElement(self::PARTS),
            ]);
        });
    }
}
