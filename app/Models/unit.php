<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class unit extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->HasMany(article::class, 'unit_id');
    }
}
