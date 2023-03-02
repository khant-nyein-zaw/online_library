<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
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
