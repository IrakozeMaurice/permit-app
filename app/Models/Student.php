<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function charge()
    {
        return $this->hasOne(Charge::class);
    }

    public function contract()
    {
        return $this->hasOne(contract::class);
    }

    public function claim()
    {
        return $this->hasOne(Claim::class);
    }
}
