<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:students,email,' . $id,
            'mobile_number' => 'required|numeric|unique:students,mobile_number,' . $id,
            'medium' => 'required',
            'age' => 'required|integer',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'class' => 'nullable|string',
            'batch' => 'nullable|numeric',
            'group_id' => 'nullable|in:1,2,3,4,5',
            'Subjects' => 'nullable|in:1,2,3,4,5,6,7',
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique' => '* you entered email already exists',
            'mobile_number.unique' => '* you entered phone number already exists',
        ];
    }
}
