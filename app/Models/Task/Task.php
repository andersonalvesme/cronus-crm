<?php

namespace App\Models\Task;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_tasks';

    protected $fillable = [
        'subject',
        'description',
        'user_id',
        'type_id',
        'due_date',
        'time',
        'priority',
    ];

    protected $sortable = [
        'id', 'number', 'created_at', 'due_date', 'priority'
    ];

    protected $searchable = [
        'number'
    ];

    protected $allowedFilters = [
        'id', 'number', 'created_at', 'due_date', 'priority',
        'subject', 'status_id', 'type_id', 'status.name', 'type.name'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function exportable()
    {
        return [
            'id', 'number', 'subject', 'description', 'due_date', 'time'
        ];
    }

}
