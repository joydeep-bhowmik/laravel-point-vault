<?php

namespace JoydeepBhowmik\LaravelPointVault\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelPointVaultServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}
