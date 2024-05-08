<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['seat_number', 'flight_id', 'is_delete'];


    use HasFactory;

    public function flight()
    {
        return $this->hasOne(Flight::class, 'id', 'flight_id');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'reservation_id', 'id');
    }
}
