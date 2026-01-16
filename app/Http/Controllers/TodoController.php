<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\ExportTodoRequest;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function store(StoreTodoRequest $request): JsonResponse
    {
        $todo = $this->todoService->createTodo($request->validated());

        return response()->json([
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);
    }


    public function export(ExportTodoRequest $request)
    {
        return $this->todoService->exportExcel($request->validated());
    }
}
