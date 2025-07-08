<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTestWellDraftRequest extends FormRequest
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
        $rules= [
            'name'=>'required|string|max:255|unique:wells,name',
            'from'=>'date|after_or_equal:today',
            'to'=>'date|after:from',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'test_well_data'=>'required',
            'test_well_data.*.test_structure_description_id'=>'exists:test_structure_descriptions,id',
            'test_well_data.*.test_structure_id'=>'exists:test_structures,id'
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'The test Well name is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.date' => 'The to field must be a valid date.',
            'test_well_data.required' => 'The test data field is required.',
            'test_well_data.array' => 'The test data field must be an array.',
            'test_well_data.*.test_structure_description_id.exists' => 'The selected structure description is invalid.',
            'test_well_data.*.test_structure_id.exists' => 'The selected structure is invalid.',
            'test_well_data.*.data.required' => 'The data field is required.',
        ];
    }
}
