<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class livraison extends Model
{
    use HasFactory;

    public function itemsInDelivery()
    {
        return $this->hasMany(articleEnLivraison::class, 'livraison_id');
    }

    public function achat()
    {
        return $this->belongsTo(achat::class, 'achat_id');
    }
}
