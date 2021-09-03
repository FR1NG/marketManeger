<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achat extends Model
{
    use HasFactory;

    public function items(){
        return $this->hasMany(articleEnAchat::class,'achat_id');
    }

    public function livraison(){
        return $this->hasMany(livraison::class,'achat_id');
    }
}
