<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Captain extends Model
{    protected $fillable = ['name', 'last_name', 'flight_id', 'document', 'is_delete'];
    use HasFactory;

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'id', 'flight_id');
    }
}
