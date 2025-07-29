<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
                'title' => 'required|min:2|max:50',
                'description' => 'required|min:2|max:160',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:width=395,height=250|max:2048', // Adjust the file size and type as needed
                'image_attribute' => 'required',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:width=70,height=70|max:1024', // Adjust the file size and type as needed
                'icon_attribute' => 'required',
            ];
        }
        
        public function messages()
        {
            return [
                'title.required' => 'The title field is required.',
                'title.min' => 'The title must be at least :min characters.',
                'title.max' => 'The title may not be greater than :max characters.',
                'description.required' => 'The description field is required.',
                'description.min' => 'The description must be at least :min characters.',
                'image.mimes' => 'The image must be of type: :values.',
                'image.max' => 'The image may not be greater than :max kilobytes.',
                'icon.mimes' => 'The icon must be of type: :values.',
                'icon.max' => 'The icon may not be greater than :max kilobytes.',
            ];
        }
}
