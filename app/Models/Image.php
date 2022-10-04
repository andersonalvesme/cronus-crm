<?php

namespace App\Models;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_images';

    protected $fillable = [
        'title', 'filename', 'size', 'extension', 'dimension'
    ];

    protected $sortable = [
        'id', 'size', 'extension', 'created_at'
    ];

    protected $searchable = [];

    protected $allowedFilters = [
        'id', 'title', 'filename', 'size', 'extension', 'dimension', 'created_at'
    ];
}
