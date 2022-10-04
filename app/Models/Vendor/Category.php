<?php

namespace App\Models\Vendor;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_vendor_categories';

    protected $fillable = ['name'];

    protected $sortable = [
        'id', 'name', 'created_at'
    ];

    protected $searchable = ['name'];

    protected $allowedFilters = [];
}
