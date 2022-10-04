<?php

namespace App\Models\Item;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_item_uoms';

    protected $fillable = ['name'];

    protected $sortable = [
        'id', 'created_at', 'name'
    ];

    protected $searchable = [
        'name'
    ];

    protected $allowedFilters = [

    ];
}
