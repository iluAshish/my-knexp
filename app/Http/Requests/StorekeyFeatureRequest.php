<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorekeyFeatureRequest extends FormRequest
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
            'title' => 'required|min:2|max:48',
            'image' => 'nullable|mimes:jpg,png,jpeg|dimensions:width=100,height=100|max:512',
            'image_attribute' => 'nullable|min:2',
            'number' => 'required|numeric|min:1',
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
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
            'image_attribute.min' => 'The image attribute must be at least :min characters.',
            'number.required' => 'The number field is required.',
            'number.numeric' => 'The number field is required in numeric.',
            'number.min' => 'The number must be at least :min characters.',
        ];
    }
}
