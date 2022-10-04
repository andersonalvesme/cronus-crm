<?php

use App\Models\Role;
use App\Services\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator',
                'permissions' => json_encode(Permission::schema())
            ],
            [
                'name' => 'user',
                'description' => 'User',
                'permissions' => json_encode(Permission::schema())
            ]
        ];

        foreach ($roles as $role) {
            $r = Role::create($role);
        }
    }
}
