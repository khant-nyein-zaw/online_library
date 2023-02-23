<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'ISBN', 'publisher', 'date_published', 'author_id', 'category_id', 'shelf_id'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // parent relations
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    // child relations
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

    public function delete()
    {
        if ($this->image) {
            Storage::delete('public/' . $this->image->filename);
        }
        $this->image()->delete();
        parent::delete();
    }
}
