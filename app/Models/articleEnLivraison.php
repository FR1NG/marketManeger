<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleEnLivraison extends Model
{
    use HasFactory;

    public function livraison()
    {
        return $this->belongsTo(livraison::class, 'livraison_id');
    }

    public function article()
    {
        return $this->belongsTo(article::class, 'article_id');
    }
}
