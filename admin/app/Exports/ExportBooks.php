<?php

namespace App\Exports;

use App\Models\Book;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportBooks implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    public function collection()
    {
        return Book::with('author', 'category', 'shelf')->get();
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
            Date::dateTimeToExcel(Carbon::parse($book->date_published)),
            $book->author->name,
            $book->category->name,
            $book->shelf->shelf_no
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'ISBN',
            'Publisher',
            'Date Published',
            'Author',
            'Category',
            'Shelf No'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
