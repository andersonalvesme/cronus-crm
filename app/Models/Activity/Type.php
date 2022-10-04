<?php

namespace App\Models\Activity;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_activity_types';

    protected $sortable = [];

    protected $searchable = ['name'];

    protected $allowedFilters = [];

}
