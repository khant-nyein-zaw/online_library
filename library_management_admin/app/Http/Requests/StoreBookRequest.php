<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'title' => ['required', 'max:255', Rule::unique('books', 'title')->ignore($this->book)],
            'author' => 'required|max:255',
            'publisher' => 'required|max:255',
            'date_published' => 'required|date',
            'category' => 'required',
            'image' => File::image(),
            'shelf_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'This book already exists in the library',
            'shelf_id.required' => 'You have to specify which shelf you want to put this book'
        ];
    }
}
