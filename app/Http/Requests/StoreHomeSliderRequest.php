<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeSliderRequest extends FormRequest
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
            'image' => 'nullable|mimes:jpg,png,jpeg|dimensions:width=1920,height=1149|max:1024',
            'image_attribute' => 'nullable|min:2',
            'button_url' => 'nullable|min:1',
            'button_text' => 'nullable|min:1',
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
            'button_url.min' => 'The button URL must be at least :min characters.',
            'button_text.min' => 'The button text must be at least :min characters.',
        ];
    }
}
