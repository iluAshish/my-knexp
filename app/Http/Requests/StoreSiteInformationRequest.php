<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteInformationRequest extends FormRequest
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
            'brand_name' => 'required',
            'email_recipient' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'whatsapp_number' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jp|dimensions:width=128,height=100|max:512', // Adjust the file size and type as needed
            'logo_attribute' => 'required',
            'dashboard_logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=128,height=100|max:512', // Adjust the file size and type as needed
            'logo_attribute' => 'required',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=273,height=150|max:512', // Adjust the file size and type as needed
            'footer_logo_attribute' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'brand_name.required' => 'The brand name field is required.',
            'email_recipient.required' => 'The email recipient field is required.',
            'email.required' => 'The email field is required.',
            'phone.required' => 'The phone field is required.',
            'whatsapp_number.required' => 'The WhatsApp number field is required.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg.',
            'image.dimensions' => 'The image dimensions must be 128x100 pixels.',
            'image.max' => 'The image size must not exceed 512 KB.',
            'dashboard_logo.image' => 'The dashboard logo must be an image file.',
            'dashboard_logo.mimes' => 'The dashboard logo must be of type: jpeg, png, jpg.',
            'dashboard_logo.dimensions' => 'The dashboard logo dimensions must be 128x100 pixels.',
            'dashboard_logo.max' => 'The dashboard logo size must not exceed 512 KB.',
            'logo_attribute.required' => 'The logo attribute field is required.',
            'footer_logo.image' => 'The footer logo must be an image file.',
            'footer_logo.mimes' => 'The footer logo must be of type: jpeg, png, jpg.',
            'footer_logo.dimensions' => 'The footer logo dimensions must be 273x150 pixels.',
            'footer_logo.max' => 'The footer logo size must not exceed 512 KB.',
            'footer_logo_attribute.required' => 'The footer logo attribute field is required.',
        ];
    }
}
