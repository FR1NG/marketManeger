<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorie extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->hasMany(article::class, 'category_id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) { // before delete() method call this
            $category->articles()->delete();
            // do the rest of the cleanup...
        });
    }
}
