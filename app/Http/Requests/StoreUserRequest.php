<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule;

/**
 * @property mixed $userable_type
 */
class StoreUserRequest extends FormRequest
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
            'name'=> '',
            'image' => '',
            'description' => '',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'birthday'=> [
                'required',
            ],
            'password' => [
                'required',
                'min:6',
                'max:255',
            ],
            'userable_type' => [
                'required',
                'max:20',
            ],
            'username' => [
                'required',
                'min:3',
                'max:255',
                'unique:users'
            ],

        ];
        if(str_contains($this->userable_type,'personal')){
            $rules['cref'] = [
                'required',
                'unique:personal_trainers'
            ];
            $rules['institution'] = [
                'required',
            ];
            $rules['graduation_year'] = [
                'required',
            ];
        }
        return $rules;
    }
}
