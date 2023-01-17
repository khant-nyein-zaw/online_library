<?php

namespace App\Exports;

use App\Models\Shelf;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShelvesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Shelf::select('shelves.shelf_no', 'books.*')
            ->leftJoin('books', 'shelves.book_id', 'books.id')
            ->get();
    }
}
