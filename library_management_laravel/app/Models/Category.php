<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'categoryable_id', 'categoryable_type'];

    public function categoryable()
    {
        return $this->morphTo();
    }
}
