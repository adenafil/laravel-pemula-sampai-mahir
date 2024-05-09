<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
//    protected $stopOnFirstFailure = true;
//    /**
//     * Determine if the user is authorized to make this request.
//     */
//    public function authorize(): bool
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'email', 'max:100'],
            'password' => ['required', Password::min(6)->numbers()->symbols()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => strtolower($this->input('username'))
        ]);
    }

    protected function passedValidation(): void
    {
        $this->merge([
           'password' => bcrypt($this->input('password'))
        ]);
    }
}
