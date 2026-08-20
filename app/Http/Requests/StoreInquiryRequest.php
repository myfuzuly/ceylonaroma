<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email:rfc,dns|max:255',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'country' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:2000',
            '_pot'    => 'max:0',
        ];
    }

    public function messages(): array
    {
        return [
            'message.min'  => 'Please describe your requirements in a bit more detail.',
            'email.email'  => 'Please enter a valid business email address.',
            '_pot.max'     => 'Submission rejected.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'    => 'full name',
            'email'   => 'email address',
            'message' => 'requirements',
        ];
    }
}
