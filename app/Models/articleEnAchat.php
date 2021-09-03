<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleEnAchat extends Model
{
    use HasFactory;

    public function achat(){
        return $this->belongsTo(achat::class,'achat_id');
    }
    
    public function atricles(){
        return $this->hasOne(article::class,'article_id');
    }
}
