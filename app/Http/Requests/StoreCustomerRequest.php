<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        // return [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:customers,customer_email',
        //     'contact_name' => 'nullable|string|max:255',
        //     'contact_number' => 'nullable|string|max:20',

        //     // Address fields
        //     'street' => 'required|string|max:255',
        //     'area' => 'nullable|string|max:255',
        //     'city' => 'nullable|string|max:255',
        //     'pincode' => 'required|string|max:10',
        // ];
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255||unique:customers,customer_email',
            'contact_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',

            // Address fields
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'line3' => 'nullable|string|max:255',
            'line4' => 'nullable|string|max:255',
            'pincode' => 'required|string|max:10',
        ];
    }
}
