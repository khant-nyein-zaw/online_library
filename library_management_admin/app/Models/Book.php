<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'publisher', 'date_published', 'ISBN', 'category_id', 'shelf_id'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function returnings()
    {
        return $this->hasMany(Returning::class);
    }

    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function delete()
    {
        Storage::delete('public/' . $this->image->filename);
        $this->image()->delete();
        parent::delete();
    }
}
