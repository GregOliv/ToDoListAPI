<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;

Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/export', [TodoController::class, 'export']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
