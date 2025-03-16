<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
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
            'logo' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'website' => [
                'url',
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(Company::class)
            ],
            'phone' => [
                'max:255',
                Rule::unique(Company::class)
            ],
            'address' => [
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
            'logo.required' => 'Logo is required',
            'website.required' => 'Website is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'status.required' => 'Status is required',
        ];
    }
}