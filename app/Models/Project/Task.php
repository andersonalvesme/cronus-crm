<?php

namespace App\Models\Project;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_project_tasks';

    protected $fillable = [
        'title', 'start_date', 'due_date', 'description',
        'stage_id'
    ];

    protected $sortable = [
        'id', 'title', 'start_date', 'due_date', 'created_at'
    ];

    protected $searchable = [
        'title'
    ];

    protected $allowedFilters = [];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'id');
    }
}
