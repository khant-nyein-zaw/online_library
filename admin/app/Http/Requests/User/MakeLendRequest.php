<?php

namespace App\Http\Requests\User;

use App\Models\LendRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakeLendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $recordCount = LendRequest::where(function (Builder $query) {
            $query->where('user_id', $this->user()->id)
                ->where('book_id', $this->input('book_id'));
        })->count();
        return $recordCount ? false : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'duration' => 'required|integer|max:10'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ]));
    }
}
