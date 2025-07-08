<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTroubleshootWellDraftRequest extends FormRequest
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
            'troubleshoot_well_data'=>'required',
            'troubleshoot_well_data.*.troubleshoot_struct_desc_id'=>'exists:troubleshoot_struct_desc,id',
            'troubleshoot_well_data.*.troubleshoot_struct_id'=>'exists:troubleshoot_structs,id'
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'The troubleshoot Well name is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.date' => 'The to field must be a valid date.',
            'troubleshoot_well_data.required' => 'The troubleshoot data field is required.',
            'troubleshoot_well_data.array' => 'The troubleshoot data field must be an array.',
            'troubleshoot_well_data.*.troubleshoot_struct_desc_id.exists' => 'The selected structure description is invalid.',
            'troubleshoot_well_data.*.troubleshoot_struct_id.exists' => 'The selected structure is invalid.',
            'troubleshoot_well_data.*.data.required' => 'The data field is required.',
        ];
    }
}
