<?php

use JoydeepBhowmik\LaravelPointVault\Tests\Models\Customer;
use Illuminate\Database\Capsule\Manager as Capsule;


beforeEach(function () {

    // Include the database configuration and create tables
    require __DIR__ . '/../Config/db.php';

    // Drop all tables
    Capsule::schema()->dropAllTables();

    // Recreate tables
    require __DIR__ . '/../migrations/create_table.php';

    // Create a test customer model instance
    $this->customer = Customer::create(['name' => 'Test Customer']);
});

it('can credit points to the model', function () {
    // Credit 100 points to the customer
    $this->customer->credit(100, 'Initial deposit');

    // Assert the points relationship is established
    expect($this->customer->points()->count())->toBe(1);
    expect($this->customer->getCurrentBalance())->toBe(100);
});

it('can debit points from the model', function () {
    // Credit 200 points first
    $this->customer->credit(200, 'Initial deposit');

    // Debit 50 points
    $this->customer->debit(50, 'Purchase');

    // Assert the remaining balance is correct
    expect($this->customer->getCurrentBalance())->toBe(150);
});

it('throws exception when debiting more than balance', function () {
    $this->customer->credit(100, 'Initial deposit');

    // Attempt to debit 200 points, which should throw an exception
    $this->customer->debit(200, 'Overdraft attempt');
})->throws(Exception::class, "Insufficient balance to debit the specified amount.");
