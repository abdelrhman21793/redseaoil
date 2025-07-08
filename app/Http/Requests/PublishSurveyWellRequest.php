<?php

namespace App\Http\Requests;

use App\Models\Structure_description;
use App\Models\SurveyStructure_description;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublishSurveyWellRequest extends FormRequest
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
        //it validate for new survey_well
        if(!$this->has('survey_well_id')){
            $rules= [
                'well_id'=>'required|exists:wells,id',
                'name'=>'required|string|max:255|unique:wells,name',
                'from'=>'required|date|after_or_equal:today',
                'to'=>'required|date|after_or_equal:from',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'survey_well_data'=>'required',
                'survey_well_data.*.survey_structure_description_id'=>'exists:survey_structure_descriptions,id',
                'survey_well_data.*.survey_structure_id'=>'exists:survey_structures,id'
            ];

            $wellDataInputs = $this->input('survey_well_data');
            if(!empty($wellDataInputs)&& isset($wellDataInputs)){
                foreach ($wellDataInputs as $key => $wellDataInput) {
                    if (isset($wellDataInput['survey_structure_description_id'])) {
                        $structure_desc = SurveyStructure_description::findOrFail(
                            $wellDataInput['survey_structure_description_id']);
                        if ($structure_desc->is_require == 'Required') {
                            $rules["survey_well_data.{$key}.data"] = 'required';
                        }
                        // if(!empty($structure_desc->data)){
                        //     $rules["well_data.{key}.data"]="sometimes|exists:structure_descriptions,data";
                        // }
                    }
                }
            }
            //for validate old survey well
        }else{
            $rules= [
                'well_id'=>'required|exists:wells,id',
                'name'=>['required','string','max:255',Rule::unique('wells')->ignore($this->well_id)],
                'from'=>'required|date|after_or_equal:today',
                'to'=>'required|date|after_or_equal:from',
                'survey_well_data'=>'required',
                'survey_well_data.*.survey_structure_description_id'=>'exists:survey_structure_descriptions,id',
                'survey_well_data.*.survey_structure_id'=>'exists:survey_structures,id'
            ];
             $wellDataInputs = $this->input('survey_well_data');
            if(!empty($wellDataInputs)&& isset($wellDataInputs)){
                foreach ($wellDataInputs as $key => $wellDataInput) {
                    if (isset($wellDataInput['survey_structure_description_id'])) {
                        $structure_desc = SurveyStructure_description::findOrFail(
                            $wellDataInput['survey_structure_description_id']);
                        if ($structure_desc->is_require == 'Required') {
                            $rules["survey_well_data.{$key}.data"] = 'required';
                        }
                        // if(!empty($structure_desc->data)){
                        //     $rules["well_data.{key}.data"]="sometimes|exists:structure_descriptions,data";
                        // }
                    }
                }
            }
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'well_id.required'=>'The well is required',
            'name.required' => 'The survey Well name is required.',
            'from.required' => 'The from field is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.required' => 'The to field is required.',
            'to.date' => 'The to field must be a valid date.',
            'survey_well_data.required' => 'The survey data field is required.',
            'survey_well_data.array' => 'The survey data field must be an array.',
            'survey_well_data.*.survey_structure_description_id.exists' => 'The selected structure description is invalid.',
            'survey_well_data.*.survey_structure_id.exists' => 'The selected structure is invalid.',
            'survey_well_data.*.data.required' => 'The data field is required.',
        ];
    }

}
