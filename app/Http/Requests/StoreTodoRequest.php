<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_date' => 'required|date|after_or_equal:today',
            'time_tracked' => 'numeric|min:0',
            'status' => 'nullable|string|in:pending,open,in_progress,completed',
            'priority' => 'required|string|in:low,medium,high',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? 'pending',
            'time_tracked' => $this->time_tracked ?? 0,
        ]);
    }
}
