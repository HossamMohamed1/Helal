<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'charts.*' => ['required', Rule::in('bar', 'line', 'pie', 'table')],
            'start' => 'sometimes|nullable|before_or_equal:end',
            'end' => 'sometimes|nullable|after_or_equal:start',
            'Category' => 'nullable',
        ];
    }
}