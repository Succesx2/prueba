<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{   protected $fillable = ['name', 'is_delete'];
    use HasFactory;

    public function airports()
    {
        return $this->hasMany(Airport::class, 'country_id', 'id');
    }
}
