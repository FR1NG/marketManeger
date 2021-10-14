<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market extends Model
{
    use HasFactory;

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branchements()
    {
        return $this->hasMany(branchement::class, 'market_id');
    }
    public function achats()
    {
        return $this->hasMany(achat::class, 'market_id');
    }
    public function employees()
    {
        return $this->hasMany(employe::class, 'market_id');
    }
    public function fournisseurs()
    {
        return $this->hasMany(fournisseur::class, 'market_id');
    }
    public function cities()
    {
        return $this->hasMany(marketCity::class, 'market_id');
    }
    public function articles()
    {
        return $this->hasMany(marketArticle::class, 'market_id');
    }
    public function categories()
    {
        return $this->hasMany(marketCategory::class, 'market_id');
    }
    public function warehouse()
    {
        return $this->hasMany(warehouse::class, 'market_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($market) { // before delete() method call this
            $market->manager()->delete();
            $market->branchements()->delete();
            $market->achats()->delete();
            $market->employees()->delete();
            $market->fournisseurs()->delete();
            $market->cities()->delete();
            $market->articles()->delete();
            $market->categories()->delete();
            $market->warehouse()->delete();
        });
    }
}
