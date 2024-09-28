<?php

namespace JoydeepBhowmik\LaravelPointVault\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use JoydeepBhowmik\LaravelPointVault\Traits\HasPoints;

class Customer extends Model
{
    use HasPoints;

    protected $fillable = ['name'];
}
