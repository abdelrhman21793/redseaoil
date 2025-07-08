<?php

namespace App\Http\Requests;

use App\Models\Structure_description;
use App\Models\TroubleshootStructure_description;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublishTroubleshootWellRequest extends FormRequest
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
        if(!$this->has('troubleshoot_well_id')){
            $rules= [
                'well_id'=>'required|exists:wells,id',
                'name'=>'required|string|max:255|unique:wells,name',
                'from'=>'required|date|after_or_equal:today',
                'to'=>'required|date|after_or_equal:from',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'troubleshoot_well_data'=>'required',
                'troubleshoot_well_data.*.troubleshoot_struct_desc_id'=>'exists:troubleshoot_struct_desc,id',
                'troubleshoot_well_data.*.troubleshoot_struct_id'=>'exists:troubleshoot_structs,id'
            ];

            $wellDataInputs = $this->input('troubleshoot_well_data');
            if(!empty($wellDataInputs)&& isset($wellDataInputs)){
                foreach ($wellDataInputs as $key => $wellDataInput) {
                    if (isset($wellDataInput['troubleshoot_struct_desc_id'])) {
                        $structure_desc = TroubleshootStructure_description::findOrFail(
                            $wellDataInput['troubleshoot_struct_desc_id']);
                        if ($structure_desc->is_require == 'Required') {
                            $rules["troubleshoot_well_data.{$key}.data"] = 'required';
                        }
                        // if(!empty($structure_desc->data)){
                        //     $rules["troubleshoot_well_data.{key}.data"]="sometimes|exists:structure_descriptions,data";
                        // }
                    }
                }
            }
        }else{
            $rules= [
                'well_id'=>'required|exists:wells,id',
                'name'=>['required','string','max:255',Rule::unique('wells')->ignore($this->well_id)],
                'from'=>'required|date|after_or_equal:today',
                'to'=>'required|date|after_or_equal:from',
                'troubleshoot_well_data'=>'required',
                'troubleshoot_well_data.*.troubleshoot_struct_desc_id'=>'exists:troubleshoot_struct_desc,id',
                'troubleshoot_well_data.*.troubleshoot_struct_id'=>'exists:troubleshoot_structs,id'
            ];
             $wellDataInputs = $this->input('troubleshoot_well_data');
            if(!empty($wellDataInputs)&& isset($wellDataInputs)){
             foreach ($wellDataInputs as $key => $wellDataInput) {
                 if (isset($wellDataInput['troubleshoot_struct_desc_id'])) {
                     $structure_desc = TroubleshootStructure_description::findOrFail(
                         $wellDataInput['troubleshoot_struct_desc_id']);
                     if ($structure_desc->is_require == 'Required') {
                         $rules["troubleshoot_well_data.{$key}.data"] = 'required';
                     }
                     // if(!empty($structure_desc->data)){
                     //     $rules["troubleshoot_well_data.{key}.data"]="sometimes|exists:structure_descriptions,data";
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
            'name.required' => 'The Well name is required.',
            'from.required' => 'The from field is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.required' => 'The to field is required.',
            'to.date' => 'The to field must be a valid date.',
            'troubleshoot_well_data.required' => 'The well data field is required.',
            'troubleshoot_well_data.array' => 'The well data field must be an array.',
            'troubleshoot_well_data.*.troubleshoot_struct_desc_id.exists' => 'The selected structure description is invalid.',
            'troubleshoot_well_data.*.troubleshoot_struct_id.exists' => 'The selected structure is invalid.',
            'troubleshoot_well_data.*.data.required' => 'The data field is required.',
        ];
    }

}
