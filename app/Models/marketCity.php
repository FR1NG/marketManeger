<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marketCity extends Model
{
    use HasFactory;


    public function branchements()
    {
        return $this->hasMany(branchement::class, 'city_id');
    }
}
