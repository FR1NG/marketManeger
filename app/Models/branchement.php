<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branchement extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(articleEnBranchement::class, 'branchement_id');
    }
    public function employees()
    {
        return $this->hasMany(employesEnBranchement::class, 'branchement_id');
    }
    public function city()
    {
        return $this->belongsTo(marketCity::class, 'city_id');
    }
    public function marketArticle()
    {
        return $this->belongsTo(marketArticle::class, 'market_article_id');
    }
    public function charges()
    {
        return $this->hasMany(branchementChargers::class, 'branchement_id');
    }
    public function images()
    {
        return $this->hasMany(branchementImage::class, 'branchement_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($branchement) { // before delete() method call this
            $branchement->employees()->delete();
            $branchement->charges()->delete();
            $branchement->images()->delete();
            // do the rest of the cleanup...
            $dir = storage_path('app/public/branchements/' . $branchement->id);
            system('rm -rf -- ' . escapeshellarg($dir), $retval);
        });
    }
}
