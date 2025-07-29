<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeAboutUsRequest extends FormRequest
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
            'sub_title' => 'required|min:2|max:50',
            'image' => 'nullable|mimes:jpg,png,jpeg|dimensions:width=830,height=1000|max:2048',
            'image_attribute' => 'nullable|min:2',
            'description' => 'nullable|min:1',
            'title_2' => 'nullable|min:1',
            'description_2' => 'nullable|min:1',
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
            'sub_title.required' => 'The sub title field is required.',
            'sub_title.min' => 'The sub title must be at least :min characters.',
            'sub_title.max' => 'The sub title may not be greater than :max characters.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
            'image_attribute.min' => 'The image attribute must be at least :min characters.',
            'description.min' => 'The description must be at least :min characters.',
            'title_2.min' => 'The title 2 must be at least :min characters.',
            'description_2.min' => 'The description 2 must be at least :min characters.',
        ];
    }
}
