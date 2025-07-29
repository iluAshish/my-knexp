<?php

namespace App\Http\Requests;

use App\Rules\AllowedWeekdays;
use App\Rules\NotInDateLockDays;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'shipment_date' => [
                'required',
                'date',
                'after_or_equal:today',
                new NotInDateLockDays(),
                new AllowedWeekdays(),
            ],
            'items' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'state_id' => 'required|exists:states,id',
            'customer.first_name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'customer.last_name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'customer.email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'customer.phone' => [
                'required',
                'regex:/^(\+\d+|\d+)$/',
                'min:8',
                'max:20',
            ],
            'customer.address' => 'required|string',
            'sender.name' => 'nullable|string|regex:/^[a-zA-Z\s]+$/',
            'servicetype' => 'nullable|string|regex:/^[a-zA-Z\s]+$/',
            'sender.email' => [
                'nullable',
                'email',
                'regex:/^[a-zA-Z0-9._]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'sender.phone' => [
                'nullable',
                'regex:/^(\+\d+|\d+)$/',
                'min:8',
                'max:20',
            ],
            'sender.address' => 'nullable|string',
        ];
    }
}