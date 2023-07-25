<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Resources\RegisterResource;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'api_name' => 'Laravel API.',
        'api_version' => '1.0.1'
    ]);
});
Route::post('/register', [RegisterController::class, 'store']);
Route::patch('/register/{id}', [RegisterController::class, 'update']);
Route::get('/register/{id}', function (string $id) {
    return new RegisterResource(Register::findOrFail($id));
});

Route::get('/register-list', function () {
  $registers = Register::paginate();
  return RegisterResource::collection($registers);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
