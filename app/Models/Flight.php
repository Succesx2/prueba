<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = ['airline_id','airport_exit', 'airport_entrance', 'max_seats', 'reserved_seats', 'code', 'airport_id', 'airplane_id', 'is_delete', 'is_full'];

    public function airplane()
    {
        return $this->hasMany(Airplane::class, 'id', 'airplane_id');
    }

    public function captain()
    {
        return $this->hasOne(Captain::class, 'flight_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'flight_id', 'id');
    }
    public function airport()
    {
        return $this->hasOne(Airport::class, 'id', 'airport_id');
    }

    public function airline()
    {
        return $this->hasOne(Airline::class, 'id', 'airline_id');

    }
}
