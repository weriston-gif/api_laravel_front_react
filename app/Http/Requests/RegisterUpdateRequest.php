<?php

namespace App\Http\Requests;

use App\Models\Register;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $registerId = $this->route('id'); // Obtém o ID do registro sendo atualizado da rota

        return [
            'name' => [
                'string',
                'min:5',
                'max:255',
            ],
            'email' => [
                'email', 'max:255',
                Rule::unique(Register::class)->ignore($registerId, 'id'),
            ],
            'cpf' => [
                Rule::unique(Register::class)->ignore($registerId, 'id'),
            ],
            'data_nasc' => 'date_format:d/m/Y',
            'gender' => 'in:Masculino,Feminino,Outros',
        ];
    }
}
