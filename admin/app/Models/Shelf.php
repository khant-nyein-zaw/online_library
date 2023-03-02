<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $fillable = ['shelf_no'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
