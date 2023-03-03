<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Book;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
        Validator::make($row, [
            'title' => ['required', 'max:255', Rule::unique('books', 'title')],
            'ISBN' => [
                'required',
                'regex:/(ISBN[-]*(1[03])*[ ]*(: ){0,1})*(([0-9Xx][- ]*){13}|([0-9Xx][- ]*){10})/',
                Rule::unique('books', 'ISBN')
            ],
            'publisher' => 'required|max:255',
            'date_published' => 'required',
            'category_id' => 'required|integer',
            'shelf_id' => 'required|integer',
            'author_id' => 'required|integer',
        ])->validate();

        return new Book([
            'title' => $row['title'],
            'ISBN' => $row['isbn'],
            'publisher' => $row['publisher'],
            'date_published' => Carbon::instance(Date::excelToDateTimeObject($row['date_published'])),
            'author_id' => $row['author_id'],
            'category_id' => $row['category_id'],
            'shelf_id' => $row['shelf_id']
        ]);
    }
}
