<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marketArticle extends Model
{
    use HasFactory;

    public function branchements()
    {
        return $this->hasMany(branchement::class, 'market_article_id');
    }
}
