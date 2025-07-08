<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StructureDescRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule=[
            'option_id'=>'integer|required',
            'structureName'=>'required|string|max:255',
            'structuresDes'=>'array',
            'structuresDes.*.input'=>'required|max:255',
            'structuresDesMenu.*.input'=>'required|max:255',
            'structuresDesMenu.*.data'=>'required|max:255',
        ];
        return $rule;
    }

    public function messages()
    {
        return [
            'option_id.required' => 'The Option is required.',
            'structureName.required' => 'The Structure Name field is required.',
            'structuresDes.*.input.required' => 'The Input of Structure Description is required.',
            'structuresDesMenu.*.input.required' => 'The Input of Structure Menu is required.',
            'structuresDesMenu.*.data.required' => 'The Data of Structure Menu is required.',
        ];
    }
}
