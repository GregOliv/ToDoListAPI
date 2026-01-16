<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'assignee' => 'nullable|string',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
            'status' => 'nullable|string',
            'priority' => 'nullable|string',
        ];
    }
}
