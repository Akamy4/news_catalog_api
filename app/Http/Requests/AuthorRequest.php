<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'full_name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'Имя автора',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Поле :attribute не должно быть пусто',
        ];
    }
}
