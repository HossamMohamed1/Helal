<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class updateProfileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . auth()->id(),
            // 'password' => 'required',
            'newpassword' => ['nullable', 'string', 'min:8'],
            'phone' => 'nullable|numeric|unique:users,phone,' . auth()->id(),
            'image' => 'nullable|image|mimes:png,jpg,jpeg',

        ];
    }
}