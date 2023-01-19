<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShelfRequest extends FormRequest
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
            'shelf_no' => 'required',
            'book_id' => ['required', 'array'],
            'book_id.*' => Rule::unique('shelves', 'book_id')->ignore($this->shelves)
        ];
    }

    public function messages()
    {
        return [
            'book_id.*' => 'Book #:position is already added to another shelf'
        ];
    }
}
