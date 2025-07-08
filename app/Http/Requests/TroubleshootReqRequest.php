<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TroubleshootReqRequest extends FormRequest
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
        return [
            'troubleshoot_well_id'=>'exists:troubleshoot_wells,id',
            'description'=>'required|string|max:1025'
        ];
    }
}
