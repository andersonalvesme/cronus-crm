<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name', 'price', 'invoice_period', 'trial_ends_at', 'active_users_limit', 'active'
    ];

    protected $sortable = [
        'id', 'created_at'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id', 'id');
    }

}
