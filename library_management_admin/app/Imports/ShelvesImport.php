<?php

namespace App\Imports;

use App\Models\Shelf;
use Maatwebsite\Excel\Concerns\ToModel;

class ShelvesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Shelf([
            'shelf_no' => $row['0'],
            'book_id' => $row['1']
        ]);
    }
}
