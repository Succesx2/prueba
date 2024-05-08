<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{   protected $fillable = ['name', 'country_id', 'is_delete'];
    use HasFactory;

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function airlines()
    {
        return $this->hasMany(Airline::class, 'airport_id', 'id');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'airport_id', 'id');
    }
}
