<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'first_name' => 'required|string|max:30|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'nullable|string|max:30|regex:/^[a-zA-Z\s]+$/',
            // 'email' => 'required|string|email|unique:customers,email,' . $this->route('customer')->id,
            'email' => [
                'required',
                'email',
                'unique:customers,email,' . $this->route('customer')->id,
                'regex:/^[a-zA-Z0-9._]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            // 'phone' => 'required|string|max:20',
            'phone' => [
                'required',
                'regex:/^(\+\d+|\d+)$/',
                'min:8',
                'max:20',
            ],
            'address' => 'required|string|max:255',
        ];
    }
}
