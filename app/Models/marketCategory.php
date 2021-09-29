<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marketCategory extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->hasMany(marketArticle::class, 'market_category_id');
    }
}
