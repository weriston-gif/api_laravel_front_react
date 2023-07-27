<?php

namespace App\Services;

use App\Models\Register;

class RegisterService
{
    /**
     * Registra um novo usuário.
     *
     * @param  array  $userData Dados do usuário a serem registrados
     * @return bool True se o registro for bem-sucedido, false caso contrário
     */
    public function store(array $userData): bool
    {
        try {
            $newRegister = new Register($userData);
            $newRegister->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(int $id, array $userData): bool
    {
        try {
            $register = Register::findOrFail($id);
            $register->update($userData);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Valida um número de CPF
     */
    public function validarCPF(string $cpf): bool
    {
        // Remove caracteres não numéricos do CPF
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais (CPF inválido)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
