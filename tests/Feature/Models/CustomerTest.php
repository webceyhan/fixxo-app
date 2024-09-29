<?php

use App\Models\Customer;
use App\Models\Device;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

it('can initialize customer', function () {
    $customer = new Customer();

    expect($customer->id)->toBeNull();
    expect($customer->name)->toBeNull();
    expect($customer->company)->toBeNull();
    expect($customer->vat_number)->toBeNull();
    expect($customer->email)->toBeNull();
    expect($customer->phone)->toBeNull();
    expect($customer->address)->toBeNull();
    expect($customer->note)->toBeNull();
    expect($customer->created_at)->toBeNull();
    expect($customer->updated_at)->toBeNull();
});

it('can create customer', function () {
    $customer = Customer::factory()->create();

    expect($customer->id)->toBeInt();
    expect($customer->name)->toBeString();
    expect($customer->company)->toBeNull();
    expect($customer->vat_number)->toBeNull();
    expect($customer->email)->toBeString();
    expect($customer->phone)->toBeString();
    expect($customer->address)->toBeString();
    expect($customer->note)->toBeString();
    expect($customer->created_at)->toBeInstanceOf(Carbon::class);
    expect($customer->updated_at)->toBeInstanceOf(Carbon::class);
});

it('can create customer with company', function () {
    $customer = Customer::factory()->withCompany()->create();

    expect($customer->company)->toBeString();
    expect($customer->vat_number)->toBeString();
});

it('can create customer without email address', function () {
    $customer = Customer::factory()->withoutEmail()->create();

    expect($customer->email)->toBeNull();
});

it('can create customer without phone number', function () {
    $customer = Customer::factory()->withoutPhone()->create();

    expect($customer->phone)->toBeNull();
});

it('can create customer without address', function () {
    $customer = Customer::factory()->withoutAddress()->create();

    expect($customer->address)->toBeNull();
});

it('can create customer without note', function () {
    $customer = Customer::factory()->withoutNote()->create();

    expect($customer->note)->toBeNull();
});

it('can update customer', function () {
    $customer = Customer::factory()->create();

    $customer->update([
        'name' => 'Bill Gates',
        'company' => 'Microsoft Corporation',
        'vat_number' => 'US1234567890',
        'email' => 'bill.gates@mail.com',
        'phone' => '+1234567890',
        'address' => 'Redmond, Washington, USA',
        'note' => 'Co-founder of Microsoft Corporation',
    ]);

    expect($customer->name)->toBe('Bill Gates');
    expect($customer->company)->toBe('Microsoft Corporation');
    expect($customer->vat_number)->toBe('US1234567890');
    expect($customer->email)->toBe('bill.gates@mail.com');
    expect($customer->phone)->toBe('+1234567890');
    expect($customer->address)->toBe('Redmond, Washington, USA');
    expect($customer->note)->toBe('Co-founder of Microsoft Corporation');
});

it('can delete customer', function () {
    $customer = Customer::factory()->create();

    $customer->delete();

    expect(Customer::find($customer->id))->toBeNull();
});

// Devices /////////////////////////////////////////////////////////////////////////////////////////

it('can have many devices', function () {
    $customer = Customer::factory()->hasDevices(2)->create();

    expect($customer->devices)->toHaveCount(2);
});

it('can delete customer with devices', function () {
    $customer = Customer::factory()->hasDevices(2)->create();

    $customer->delete();

    expect(Customer::find($customer->id))->toBeNull();
    expect(Device::count())->toBe(0);
});

// Tickets /////////////////////////////////////////////////////////////////////////////////////////

it('can have many tickets', function () {
    $customer = Customer::factory()->hasTickets(2)->create();

    expect($customer->tickets)->toHaveCount(2);
});

it('can delete customer with tickets', function () {
    $customer = Customer::factory()->hasTickets(2)->create();

    $customer->delete();

    expect(Customer::find($customer->id))->toBeNull();
    expect(Ticket::count())->toBe(0);
});
