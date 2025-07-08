<?php

namespace App\Http\Requests;

use App\Models\SurveyStructure_description;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSurveyWellDraftRequest extends FormRequest
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
            'survey_well_data'=>'required',
            'survey_well_data.*.survey_structure_description_id'=>'exists:survey_structure_descriptions,id',
            'survey_well_data.*.survey_structure_id'=>'exists:survey_structures,id'
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'The survey Well name is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.date' => 'The to field must be a valid date.',
            'survey_well_data.required' => 'The survey data field is required.',
            'survey_well_data.array' => 'The survey data field must be an array.',
            'survey_well_data.*.survey_structure_description_id.exists' => 'The selected structure description is invalid.',
            'survey_well_data.*.survey_structure_id.exists' => 'The selected structure is invalid.',
            'survey_well_data.*.data.required' => 'The data field is required.',
        ];
    }
}
