<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:255', Rule::unique('books', 'title')->ignore($this->route('book'))],
            'ISBN' => ['required', 'regex:/(ISBN[-]*(1[03])*[ ]*(: ){0,1})*(([0-9Xx][- ]*){13}|([0-9Xx][- ]*){10})/', Rule::unique('books', 'ISBN')->ignore($this->route('book'))],
            'publisher' => 'required|max:255',
            'date_published' => 'required|date',
            'category_id' => 'required|integer',
            'shelf_id' => 'required|integer',
            'author_id' => 'required|integer',
            'image' => File::image(),
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'This book already exists in the library',
            'category_id.integer' => 'Please choose a category',
            'shelf_id.integer' => 'Please choose a shelf number'
        ];
    }
}
