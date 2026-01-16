<?php

namespace App\Exports;

use App\Models\Todo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TodoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $todos;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function collection()
    {
        $totalTodos = $this->todos->count();
        $totalTimeTracked = $this->todos->sum('time_tracked');

        $data = $this->todos->map(function ($todo) {
            return $todo;
        });

        $data->push([
            'title' => 'SUMMARY',
            'assignee' => 'Total Todos: ' . $totalTodos,
            'due_date' => '',
            'time_tracked' => $totalTimeTracked,
            'status' => '',
            'priority' => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Assignee',
            'Due Date',
            'Time Tracked',
            'Status',
            'Priority',
        ];
    }

    public function map($todo): array
    {
        if (is_array($todo)) {
            return [
                $todo['title'],
                $todo['assignee'],
                $todo['due_date'],
                $todo['time_tracked'],
                $todo['status'],
                $todo['priority'],
            ];
        }

        return [
            $todo->title,
            $todo->assignee,
            $todo->due_date ? $todo->due_date->format('Y-m-d') : '',
            $todo->time_tracked,
            $todo->status,
            $todo->priority,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            $sheet->getHighestRow() => ['font' => ['bold' => true]],
        ];
    }
}
