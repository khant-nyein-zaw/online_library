<?php

namespace App\Models;

use App\Enums\IssuedBookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssuedBook extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'issued_date', 'due_date', 'returned_date', 'fine', 'status'];

    public $timestamps = false;

    protected $casts = [
        'status' => IssuedBookStatus::class
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
