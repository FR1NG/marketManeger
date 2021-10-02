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
}
