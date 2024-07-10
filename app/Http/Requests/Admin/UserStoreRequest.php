<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'     => 'required|max:255',
            'username' => 'required|unique:users|min:6|max:15',
            'email'    => 'required|unique:users|email:dns',
            'password' => 'required|min:6',
            'level'    => 'required'
        ];
    }
}
