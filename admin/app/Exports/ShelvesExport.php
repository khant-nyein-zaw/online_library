<?php

namespace App\Exports;

use App\Models\Shelf;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShelvesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Shelf::withCount('books')->get();
    }

    /**
     * @var Shelf $shelf
     */
    public function map($shelf): array
    {
        return [
            $shelf->shelf_no,
            $shelf->books_count,
        ];
    }

    public function headings(): array
    {
        return [
            'shelf_no',
            'books',
        ];
    }
}
