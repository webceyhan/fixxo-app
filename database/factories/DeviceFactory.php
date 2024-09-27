<?php

namespace Database\Factories;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 * 
 * @method static hasTickets(int $count = 1, array $attributes = [])
 */
class DeviceFactory extends Factory
{
    const VERSIONS = [
        'iMac' => ['21"', '27"'],
        'Mac' => ['Mini', 'Pro', 'Studio'],
        'MacBook' => ['Air', 'Pro'],
        'iPad' => ['Mini', 'Air', 'Pro'],
        'iPhone' => ['SE', 'X', 'Pro', 'Max', 'Pro Max'],
        'Galaxy' => ['S10', 'S20', 'S21'],
        'Galaxy Tab' => ['A', 'S', 'E'],
        'Vaio' => ['Pro', 'Slim'],
        'PlayStation' => ['4', '5'],
        'Pavilion' => ['Gaming', 'Business'],
        'Deskjet' => ['1000', '2000'],
        'Thinkpad' => ['X1', 'T'],
        'Go Comfort' => ['5"', '6"'],
    ];

    const BRANDS = [
        'iMac' => 'Apple',
        'Mac' => 'Apple',
        'MacBook' => 'Apple',
        'iPad' => 'Apple',
        'iPhone' => 'Apple',
        'Galaxy' => 'Samsung',
        'Galaxy Tab' => 'Samsung',
        'Vaio' => 'Sony',
        'PlayStation' => 'Sony',
        'Pavilion' => 'Hp',
        'Deskjet' => 'Hp',
        'Thinkpad' => 'Lenovo',
        'Go Comfort' => 'TomTom',
    ];

    const TYPES = [
        'iMac' => DeviceType::Desktop,
        'Mac' => DeviceType::Desktop,
        'MacBook' => DeviceType::Laptop,
        'iPad' => DeviceType::Tablet,
        'iPhone' => DeviceType::Phone,
        'Galaxy' => DeviceType::Phone,
        'Galaxy Tab' => DeviceType::Tablet,
        'Vaio' => DeviceType::Laptop,
        'PlayStation' => DeviceType::Other,
        'Pavilion' => DeviceType::Desktop,
        'Deskjet' => DeviceType::Other,
        'Thinkpad' => DeviceType::Laptop,
        'Go Comfort' => DeviceType::Other,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // generate random model name and version
        $name = fake()->randomElement(array_keys(self::VERSIONS));
        $version = fake()->randomElement(self::VERSIONS[$name]);

        return [
            'customer_id' => Customer::factory(),
            'model' => "{$name} {$version}",
            'brand' => self::BRANDS[$name],
            'serial_number' => fake()->uuid(),
            'type' => self::TYPES[$name],
            'status' => DeviceStatus::CheckedIn,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the device belongs to the given customer.
     */
    public function forCustomer(Customer $customer): self
    {
        return $this->state(fn(array $attributes) => [
            'customer_id' => $customer->id,
            'created_at' => fake()->dateTimeBetween($customer->created_at),
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the device has no brand.
     */
    public function withoutBrand(): self
    {
        return $this->state(fn(array $attributes) => [
            'brand' => null
        ]);
    }

    /**
     * Indicate that the device has no serial number.
     */
    public function withoutSerialNumber(): self
    {
        return $this->state(fn(array $attributes) => [
            'serial_number' => null
        ]);
    }

    /**
     * Indicate that the device has warranty for the given number of years.
     */
    public function withWarranty(int $years = 1): self
    {
        return $this->state(fn(array $attributes) => [
            'warranty_expire_date' => now()->addYear($years),
        ]);
    }

    /**
     * Indicate that the device is of the given type.
     */
    public function ofType(DeviceType $type): self
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }

    /**
     * Indicate that the device is of the given status.
     */
    public function ofStatus(DeviceStatus $status): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }
}
