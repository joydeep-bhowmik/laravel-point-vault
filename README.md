---

# Laravel Point Vault Documentation

## Introduction

**Laravel Point Vault** provides a flexible points system for your Laravel models. This package allows models to have a "points vault" where you can easily debit and credit points, keep track of balances, and record transactions.

This documentation will guide you through the installation, configuration, and usage of the package.

---

## Requirements

- Laravel version: `^8.0` or higher
- PHP version: `^7.4` or higher

---

## Installation

To install the package, use Composer:

```bash
composer require joydeep-bhowmik/laravel-point-vault
```

### Register the Service Provider

You need to register the package's service provider. If you're using **Laravel 5.5** or later, this is automatically handled by the framework’s package auto-discovery feature.

If you are using an earlier version of Laravel or if you’ve disabled auto-discovery, manually add the service provider to the `config/app.php` file:

```php
'providers' => [
    JoydeepBhowmik\LaravelPointVault\Providers\LaravelPointVaultServiceProvider::class,
],
```

### Migrations

After registering the service provider, run the package's migrations to create the necessary database table for point transactions.

```bash
php artisan migrate
```

---

## Configuration

You may want to publish the migration file (if needed) to make modifications before running migrations:

```bash
php artisan vendor:publish --provider="JoydeepBhowmik\LaravelPointVault\Providers\LaravelPointVaultServiceProvider" --tag="migrations"
```

---

## Usage

### Applying the `HasPoints` Trait

To use the points system, add the `HasPoints` trait to any Eloquent model where you want to manage points. This trait adds functionality for crediting, debiting, and checking balances.

Example:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JoydeepBhowmik\LaravelPointVault\Traits\HasPoints;

class User extends Model
{
    use HasPoints;
}
```

### Methods Provided by the `HasPoints` Trait

#### `getCurrentBalance()`

This method returns the current balance of points for the model.

```php
$balance = $user->getCurrentBalance();
echo $balance; // Outputs the user's current point balance
```

#### `credit($amount, $note = null)`

This method credits a specified amount of points to the model.

```php
$user->credit(100, 'Initial bonus');
```

#### `debit($amount, $note = null)`

This method debits a specified amount of points from the model's balance.

```php
$user->debit(50, 'Purchase item');
```

> **Note:** The debit operation checks whether the user has sufficient points before performing the transaction. If there are insufficient points, an exception will be thrown.

#### `points()`

This method defines the polymorphic relationship between the model and the `Point` model. You can use it to access all the point transactions for a model.

```php
$transactions = $user->points;
```

### Custom Point Transaction Logic

If you want to customize how points are credited or debited, you can extend the provided methods or interact with the `Point` model directly.

---

## Database Structure

The package expects a `points` table with the following columns:

- `id`: Primary key
- `pointable_id`: The ID of the model that owns the points (polymorphic relation)
- `pointable_type`: The type of the model that owns the points (polymorphic relation)
- `amount`: The number of points being credited or debited
- `transaction_type`: Either 'CREDIT' or 'DEBIT'
- `note`: An optional note for the transaction
- `created_at` / `updated_at`: Timestamps for when the transaction occurred

---

## Events

You may also hook into Laravel's event system if you wish to listen for point transactions. Although not explicitly included in the provided code, you could easily dispatch events within the `makeTransaction` method for more complex scenarios.

---

## License

This package is open-source software licensed under the [MIT license](https://github.com/joydeep-bhowmik/laravel-point-vault/blob/main/LICENSE).

---
