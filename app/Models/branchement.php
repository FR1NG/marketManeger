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
}
