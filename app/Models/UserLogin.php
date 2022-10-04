<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLogin extends Authenticatable
{

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    protected $hidden = [
        'tenant_id', 'password', 'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function metrics()
    {
        return $this->hasMany(UserMetric::class, 'user_id', 'id');
    }

    // todo cache
    public function permissions()
    {
        $items = [];

        foreach($this->role->permissions as $group) {
            foreach($group['actions'] as $key => $value) {
                if($value) {
                    $items[] = $group['name'].'.'.$key;
                }
            }
        }

        return $items;
    }

    // todo cache
    public function topLinks()
    {
        $items = [
            'overview'
        ];

        foreach($this->role->permissions as $group) {
            if($group['name'] === 'settings') {
                foreach($group['actions'] as $key => $value) {
                    if($value) {
                        $items[] = $group['name'];
                    }
                }
            } else {
                if(isset($group['actions']['index']) && !$group['actions']['index']) {
                    // not allowed
                } else {
                    $items[] = $group['name'];
                }
            }

        }

        return $items;
    }
}
