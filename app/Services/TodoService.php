<?php

namespace App\Services;

use App\Repositories\TodoRepository;
use App\Exports\TodoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Todo;

class TodoService
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Create a new todo.
     */
    public function createTodo(array $data): Todo
    {
        return $this->todoRepository->create($data);
    }

    /**
     * Generate Excel report.
     */
    public function exportExcel(array $filters)
    {
        $formattedFilters = [
            'title' => $filters['title'] ?? null,
            'assignee' => $filters['assignee'] ?? null,
            'due_date_start' => $filters['start'] ?? null,
            'due_date_end' => $filters['end'] ?? null,
            'time_tracked_min' => $filters['min'] ?? null,
            'time_tracked_max' => $filters['max'] ?? null,
            'status' => $filters['status'] ?? null,
            'priority' => $filters['priority'] ?? null,
        ];

        $todos = $this->todoRepository->getFiltered($formattedFilters);

        return Excel::download(new TodoExport($todos), 'todos_report.xlsx');
    }
}
