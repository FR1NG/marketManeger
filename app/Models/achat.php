<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achat extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(articleEnAchat::class, 'achat_id');
    }

    public function livraisons()
    {
        return $this->hasMany(livraison::class, 'achat_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(fournisseur::class, 'fournisseur_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($achat) { // before delete() method call this
            $achat->items()->delete();
            // do the rest of the cleanup...
        });
    }
}
