<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * @property mixed $password
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'=> [
                'nullable'
            ],
            'image' => [
                'nullable'
            ],
            'description' => [
                'nullable'
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id, 'id')
            ],
            'birthday'=> [
                'nullable'
            ],
            'password' => [
                'nullable',
                'min:6',
                'max:255',
            ],
            'username' => [
                'nullable',
                'min:3',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id, 'id')
            ],
            'cref' => [
                'nullable',
                Rule::unique('personal_trainer')->ignore($this->user()->userable_id, 'id')
            ],
            'institution' => [
                'nullable'
            ],
            'graduation_year' => [
                'nullable'
            ],

        ];
        return $rules;
    }
}
