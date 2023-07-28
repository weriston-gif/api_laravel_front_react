<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'email' => [
                'email', 'max:255',
                Rule::unique('registers', 'email'),
                'required',
            ],
            'cpf' => [
                Rule::unique('registers', 'cpf'),
                'required',
            ],
            'data_nasc' => 'required',
            'gender' => 'required|in:Masculino,Feminino,Outros',
        ];
    }
}
