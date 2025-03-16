<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'website' => [
                'url',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
            ],
            'phone' => [
                'string',
                'max:255',
            ],
            'address' => [
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'string',
                'in:ACTIVE,INACTIVE',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'website.required' => 'Website is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'status.required' => 'Status is required',
        ];
    }
}