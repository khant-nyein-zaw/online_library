<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreAuthorRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255', Rule::unique('authors', 'name')->ignore($this->author)],
            'bio' => ['required', 'min:10'],
            'image' => File::image()
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => ":attribute must be unique"
        ];
    }
}
