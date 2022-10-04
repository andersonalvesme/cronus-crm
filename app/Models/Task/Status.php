<?php

namespace App\Models\Task;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_task_statuses';

    protected $fillable = [
        'name', 'color', 'locked'
    ];

    protected $sortable = [
        'id', 'name', 'created_at'
    ];

    protected $searchable = [
        'name'
    ];

    protected $allowedFilters = [];
}
