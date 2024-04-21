<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class CheckVerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->check() || session()->has('updateProfile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'verification_code' => 'required|array|size:5',
            'verification_code.*' => 'required|integer',
        ];
    }
}
