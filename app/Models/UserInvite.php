<?php

namespace App\Models;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_user_invites';

    protected $sortable = [
        'id', 'email', 'name', 'created_at'
    ];

    protected $searchable = [];

    protected $allowedFilters = [
        'id', 'email', 'name', 'token', 'created_at'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
