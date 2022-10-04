<?php

namespace App\Models\Opportunity;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_opportunity_stages';

    protected $fillable = [
        'name', 'color', 'locked'
    ];

    protected $sortable = [
        'id', 'name', 'created_at'
    ];

    protected $searchable = ['name'];

    protected $allowedFilters = [];
}
