<?php

namespace App\Models;

use App\Support\Filterable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Filterable;

    protected $table = 'vw_users';

    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    protected $hidden = [
        'tenant_id', 'password', 'remember_token'
    ];

    protected $sortable = [
        'id', 'created_at'
    ];

    protected $searchable = [
        'name', 'email'
    ];

    protected $allowedFilters = [
        'id', 'created_at', 'name', 'email', 'role.name'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
