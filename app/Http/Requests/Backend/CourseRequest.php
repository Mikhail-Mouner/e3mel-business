<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|min:3|max:191',
                    'category_id' => 'required|exists:App\Models\Category,id',
                    'description' => 'required|string',
                    'rating' => 'nullable|numeric|min:0|max:5',
                    'view' => 'nullable|numeric',
                    'level' => [ 'nullable', Rule::in( [ 'beginner', 'immediate', 'high' ] ) ],
                    'hours' => 'nullable|numeric',
                    'active' => 'required|numeric|boolean',
                ];
            }
            default:
                break;
        };
    }

}
