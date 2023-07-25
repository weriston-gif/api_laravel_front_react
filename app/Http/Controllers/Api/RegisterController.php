<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterUpdateRequest;
use App\Http\Resources\RegisterResource;
use App\Models\Register;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        try {
            $cpf = $request->cpf;

            if (!$this->registerService->validarCPF($cpf)) {
                return response()->json(['errors' => ['cpf' => 'CPF inválido']], 422);
            }
            if ($this->registerService->store($request->all())) {
                return response()->json(['message' => 'Registro armazenado com sucesso.'], 200);
            } else {
                return response()->json(['message' => 'Ocorreu um erro ao armazenar o registro.'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao armazenar o registro.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterUpdateRequest $request, string $id)
    {
        try {

            $cpf = $request->cpf;

            if (!$this->registerService->validarCPF($cpf)) {
                return response()->json(['errors' => ['cpf' => 'CPF inválido']], 422);
            }
            if ($this->registerService->update($id, $request->all())) {
                return response()->json(['message' => 'Registro atualizado e armazenado com sucesso.'], 200);
            } else {
                return response()->json(['message' => 'Ocorreu um erro ao atualizar e armazenar o registro.'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $register = Register::findOrFail($id);
            $register->delete();

            return response()->json(['message' => 'Registro excluído com sucesso.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Registro não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao excluir o registro.'], 500);
        }
    }
}
