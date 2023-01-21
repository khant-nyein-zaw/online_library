<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBooks implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);
        return new Book([
            'title' => $row['title'],
            'author' => $row['author'],
            'publisher' => $row['publisher'],
            'date_published' => $row['date_published'],
            'shelf_id' => $row['shelf_id']
        ]);
    }
}
