<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
                'state_id' => 'required|exists:states,id',
                'name' => 'required|min:2|max:30',
                'branch_code' => 'required|min:4|max:4',
                'phone' => [
                    'required',
                    'regex:/^(\+\d+|\d+)$/',
                    'min:8',
                    'max:20',
                ],
                'address' => 'required|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'state_id.required' => 'The state is required.',
            'state_id.exists' => 'Invalid state selected.',
            'name.required' => 'The name is required.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',
            'phone.required' => 'The phone number is required.',
            'phone.numeric' => 'The phone number must be numeric.',
            'address.required' => 'The address is required.',
            'address.max' => 'The address may not be greater than :max characters.',
        ];
    }
}
