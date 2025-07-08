<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveDraftRequest extends FormRequest
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
        $wellId = $this->input('well_id');
        $rule=[
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('wells', 'name')->ignore($wellId),
            ],
            'from'=>'date',
            'to'=>'date',
            'images'=>'',
            'well_data'=>'array',
            'well_data.*.structure_description_id'=>'exists:structure_descriptions,id',
            'well_data.*.structure_id'=>'exists:structures,id'
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'The Well name is required.',
            'from.date' => 'The from field must be a valid date.',
            'to.date' => 'The to field must be a valid date.',
            'well_data.array' => 'The well data field must be an array.',
            'well_data.*.structure_desc_id.exists' => 'The selected structure description is invalid.',
            'well_data.*.structure_id.exists' => 'The selected structure is invalid.',
        ];
    }
}
