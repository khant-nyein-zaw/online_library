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
        return Shelf::all();
    }
}
