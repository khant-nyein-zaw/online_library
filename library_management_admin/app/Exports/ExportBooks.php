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
        return Book::with('category', 'image', 'shelf')->get();
    }

    /**
     * @var Book $book
     */
    public function map($book): array
    {
        return [
            $book->title,
            $book->author,
            $book->publisher,
            $book->date_published,
            $book->category ? $book->category->name : "No Category Added",
            $book->image ? $book->image->filename : "No Image Added",
            $book->shelf->shelf_no
        ];
    }

    public function headings(): array
    {
        return [
            'title',
            'author',
            'publisher',
            'date of publication',
            'category',
            'image',
            'shelf_no'
        ];
    }
}
