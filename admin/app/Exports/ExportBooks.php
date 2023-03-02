<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportBooks implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Book::with('author', 'category', 'image', 'shelf')->get();
    }

    /**
     * @var Book $book
     */
    public function map($book): array
    {
        return [
            $book->title,
            $book->ISBN,
            $book->publisher,
            $book->date_published,
            $book->author->name,
            $book->category->name,
            $book->image ? $book->image->filename : "No Image Added",
            $book->shelf->shelf_no
        ];
    }

    public function headings(): array
    {
        return [
            'Iitle',
            'ISBN',
            'Publisher',
            'Date of publication',
            'Author',
            'Category',
            'Image',
            'Shelf No'
        ];
    }
}
