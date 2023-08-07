<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'administrator'],
            ['name' => 'elev'],
            ['name' => 'lærer/instruktør']
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        Role::firstwhere('name','=','administrator')->permissions()->sync(Permission::all());
    }
}
