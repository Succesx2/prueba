<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    protected $fillable = ['code', 'airline_id', 'create_date', 'next_maintenance', 'is_delete'];

    use HasFactory;

    public function airline()
    {
        return $this->hasOne(Airline::class, 'id', 'airline_id');
    }

    public function flights()
    {
        return $this->hasMany(Flight::class, 'airplane_id', 'id');
    }
}
