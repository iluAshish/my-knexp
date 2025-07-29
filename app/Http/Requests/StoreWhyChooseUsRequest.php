<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhyChooseUsRequest extends FormRequest
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
            'title' => 'required|min:2|max:255',
            'sub_title' => 'required|min:2|max:255',
            'image' => 'nullable|mimes:jpg,png,jpeg|dimensions:width=707,height=700|max:1024',
            'image_attribute' => 'nullable|max:255',
            'icon_1' => 'nullable|mimes:jpg,png,jpeg,svg|dimensions:width=70,height=70|max:1024', // Adjust the file size and type as needed
            'icon_title_1' => 'nullable|max:255',
            'icon_desc_1' => 'nullable',
            'icon_2' => 'nullable|mimes:jpg,png,jpeg,svg|dimensions:width=70,height=70|max:1024', // Adjust the file size and type as needed
            'icon_title_2' => 'nullable|max:255',
            'icon_desc_2' => 'nullable',
            'icon_3' => 'nullable|mimes:jpg,png,jpeg,svg|dimensions:width=70,height=70|max:1024', // Adjust the file size and type as needed
            'icon_title_3' => 'nullable|max:255',
            'icon_desc_3' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'sub_title.required' => 'The sub title field is required.',
            'sub_title.min' => 'The sub title must be at least :min characters.',
            'sub_title.max' => 'The sub title may not be greater than :max characters.',
            
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than :max kilobytes.',
            'image_attribute.max' => 'The image attribute may not be greater than :max characters.',

            'icon_1.mimes' => 'The icon 1 must be of type: jpeg, png, jpg, gif, svg.',
            'icon_1.max' => 'The icon 1 may not be greater than :max kilobytes.',
            'icon_title_1.max' => 'The icon title 1 may not be greater than :max characters.',

            'icon_2.mimes' => 'The icon 2 must be of type: jpeg, png, jpg, gif, svg.',
            'icon_2.max' => 'The icon 2 may not be greater than :max kilobytes.',
            'icon_title_2.max' => 'The icon title 2 may not be greater than :max characters.',

            'icon_3.mimes' => 'The icon 3 must be of type: jpeg, png, jpg, gif, svg.',
            'icon_3.max' => 'The icon 3 may not be greater than :max kilobytes.',
            'icon_title_3.max' => 'The icon title 3 may not be greater than :max characters.',
        ];
    }
}
