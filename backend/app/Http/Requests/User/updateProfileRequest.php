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
            'username' => 'required|string|unique:users,username,' . $this->id ?? auth()->id(),
            'email' => 'required|string|unique:users,email,' . $this->id ?? auth()->id(),

            // 'newpassword' => ['nullable', 'string', 'min:8'],
            'phone' => 'nullable|numeric|unique:users,phone,' . $this->id ?? auth()->id(),
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg',

        ];
    }
}