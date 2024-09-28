<?php

namespace JoydeepBhowmik\LaravelPointVault\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_type', 'amount', 'note'];

    public function pointable()
    {
        return $this->morphTo();
    }
}
