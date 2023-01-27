<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'user_id', 'date_borrowed', 'due_date'];

    public function returning()
    {
        return $this->hasOne(Returning::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
