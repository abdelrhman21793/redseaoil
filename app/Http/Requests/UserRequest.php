<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user_id=$this->route('user');
        // dd($user_id);
        return [
            'name'=>'required|string|max:255|min:3',
            // 'email'=>'required|email|max:255|unique:users,email,|min:3',
            'email'=>[
                Rule::unique('users')->ignore($user_id),
                'required','email','max:255','min:3'
            ],
            'password'=>'sometimes|required|max:255|min:8',
            'image'=>'image'
        ];
    }
}
