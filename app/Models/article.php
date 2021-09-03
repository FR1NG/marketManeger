<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(categorie::class,'categorie_id');
    }
    public function unit(){
        return $this->hasOne(unit::class,'unit_id');
    }
}