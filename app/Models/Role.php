<?php

namespace App\Models;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_roles';

    protected $sortable = ['id', 'name', 'created_at'];

    protected $fillable = [
        'name', 'description', 'permissions'
    ];
    protected $searchable = ['name'];

    protected $allowedFilters = [
        'id', 'name', 'description', 'created_at'
    ];

    public function getPermissionsAttribute($value)
    {
        return json_decode($value, true);
    }
}
