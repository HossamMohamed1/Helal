<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'type' => 'required|string',
            'groupBy' => 'sometimes|nullable|string',
            'charts' => 'required|array',
            'charts.*' => 'required|in_array:',
            'start' => 'sometimes|nullable|before_or_equal:end',
            'end' => 'sometimes|nullable|after_or_equal:start',
        ];
    }
}
