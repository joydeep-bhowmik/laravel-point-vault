<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

// Create the `points` table
Capsule::schema()->create('points', function (Blueprint $table) {
    $table->id();
    $table->morphs('pointable'); // Creates `pointable_id` and `pointable_type` columns
    $table->integer('amount');
    $table->string('transaction_type');
    $table->string('note')->nullable();
    $table->timestamps();
});

// Create the `customers` table
Capsule::schema()->create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
