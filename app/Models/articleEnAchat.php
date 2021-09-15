<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleEnAchat extends Model
{
    use HasFactory;
    protected $fillable = [
        'achat_id',
        'article_id',
        'price',
        'quantity'
    ];

    public function achat()
    {
        return $this->belongsTo(achat::class, 'achat_id');
    }

    public function article()
    {
        return $this->hasOne(article::class, 'id', 'article_id');
    }
}
