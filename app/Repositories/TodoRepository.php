<?php

namespace App\Repositories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository
{
    /**
     * Create a new todo.
     */
    public function create(array $data): Todo
    {
        return Todo::create($data);
    }

    /**
     * Get todos with filters.
     */
    public function getFiltered(array $filters): Collection
    {
        $query = Todo::query();

        if (!empty($filters['title'])) {
            $query->where('title', 'LIKE', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['assignee'])) {
            $assignees = explode(',', $filters['assignee']);
            $query->whereIn('assignee', $assignees);
        }

        if (!empty($filters['due_date_start']) && !empty($filters['due_date_end'])) {
            $query->whereBetween('due_date', [$filters['due_date_start'], $filters['due_date_end']]);
        }

        if (!empty($filters['time_tracked_min']) && !empty($filters['time_tracked_max'])) {
            $query->whereBetween('time_tracked', [$filters['time_tracked_min'], $filters['time_tracked_max']]);
        }

        if (!empty($filters['status'])) {
            $statuses = explode(',', $filters['status']);
            $query->whereIn('status', $statuses);
        }

        if (!empty($filters['priority'])) {
            $priorities = explode(',', $filters['priority']);
            $query->whereIn('priority', $priorities);
        }

        return $query->get();
    }
}
