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
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'administrator'],
            ['name' => 'lærer'],
            ['name' => 'instruktør'],
            ['name' => 'elev'],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
        Role::firstwhere('name','=','administrator')->permissions()->sync(Permission::all());
    }
}
