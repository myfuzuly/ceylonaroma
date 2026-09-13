<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'email'           => 'required|email:rfc,dns|max:255',
            'phone'           => 'nullable|string|max:50',
            'company'         => 'nullable|string|max:255',
            'country'         => 'required|string|max:100',
            'message'         => 'required|string|min:10|max:2000',
            '_pot'            => 'max:0',
            'recaptcha_token' => 'required|string',
        ];
    }

    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->has('recaptcha_token')) {
                return;
            }

            $secret = config('recaptcha.secret_key');
            if (!$secret) {
                return;
            }

            try {
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $secret,
                    'response' => $this->input('recaptcha_token'),
                    'remoteip' => $this->ip(),
                ])->json();
            } catch (\Throwable $e) {
                \Log::error('reCAPTCHA verification request failed: ' . $e->getMessage());
                $validator->errors()->add('recaptcha_token', 'Verification failed. Please try again.');
                return;
            }

            $success = $response['success'] ?? false;
            $score   = $response['score'] ?? 0;
            $minScore = (float) config('recaptcha.min_score', 0.5);

            if (!$success || $score < $minScore) {
                $validator->errors()->add('recaptcha_token', 'We could not verify you are human. Please try again.');
            }
        });
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
