<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $fillable = ['name', 'airport_id', 'is_delete'];

    use HasFactory;
    public function airport()
    {
        return $this->hasOne(Airport::class, 'id', 'airport_id');
    }

    public function airplanes()
    {
        return $this->hasMany(Airplane::class, 'airline_id', 'id');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'airline_id', 'id');

    }
}
