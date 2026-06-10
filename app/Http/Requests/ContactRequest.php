<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'email.required' => 'We need your email address to get in touch.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'Please write a brief message describing your inquiry.',
            'message.min' => 'Your message must be at least 10 characters long.',
        ];
    }
}
