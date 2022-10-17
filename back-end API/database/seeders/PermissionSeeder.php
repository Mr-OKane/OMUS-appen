<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'absence.viewAny'],
            ['name' => 'absence.view'],
            ['name' => 'absence.create'],
            ['name' => 'absence.update'],
            ['name' => 'absence.delete'],
            ['name' => 'address.viewAny'],
            ['name' => 'address.view'],
            ['name' => 'address.update'],
            ['name' => 'address.delete'],
            ['name' => 'chat.viewAny'],
            ['name' => 'chat.view'],
            ['name' => 'chat.create'],
            ['name' => 'chat.update'],
            ['name' => 'chat.delete'],
            ['name' => 'chat.delete.force'],
            ['name' => 'chat.restore'],
            ['name' => 'chatroom.viewAny'],
            ['name' => 'chatroom.view'],
            ['name' => 'chatroom.create'],
            ['name' => 'chatroom.update'],
            ['name' => 'chatroom.delete'],
            ['name' => 'chatroom.delete.force'],
            ['name' => 'chatroom.restore'],
            ['name' => 'idea.viewAny'],
            ['name' => 'idea.view'],
            ['name' => 'idea.create'],
            ['name' => 'idea.update'],
            ['name' => 'idea.delete'],
            ['name' => 'instrument.viewAny'],
            ['name' => 'instrument.view'],
            ['name' => 'instrument.create'],
            ['name' => 'instrument.update'],
            ['name' => 'instrument.delete'],
            ['name' => 'message.viewAny'],
            ['name' => 'message.view'],
            ['name' => 'message.create'],
            ['name' => 'message.update'],
            ['name' => 'message.delete'],
            ['name' => 'notification.viewAny'],
            ['name' => 'notification.view'],
            ['name' => 'notification.update'],
            ['name' => 'notification.delete'],
            ['name' => 'order.viewAny'],
            ['name' => 'order.view'],
            ['name' => 'order.update'],
            ['name' => 'order.delete'],
            ['name' => 'order.delete.force'],
            ['name' => 'order.restore'],
            ['name' => 'orderstatus.viewAny'],
            ['name' => 'orderstatus.view'],
            ['name' => 'orderstatus.create'],
            ['name' => 'orderstatus.update'],
            ['name' => 'orderstatus.delete'],
            ['name' => 'permission.viewAny'],
            ['name' => 'postalcode.viewAny'],
            ['name' => 'postalcode.view'],
            ['name' => 'practicedate.viewAny'],
            ['name' => 'practicedate.view'],
            ['name' => 'practicedate.create'],
            ['name' => 'practicedate.update'],
            ['name' => 'practicedate.delete'],
            ['name' => 'product.viewAny'],
            ['name' => 'product.view'],
            ['name' => 'product.create'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],
            ['name' => 'product.delete.force'],
            ['name' => 'product.restore'],
            ['name' => 'role.viewAny'],
            ['name' => 'role.view'],
            ['name' => 'role.create'],
            ['name' => 'role.update'],
            ['name' => 'role.delete'],
            ['name' => 'role.delete.force'],
            ['name' => 'role.restore'],
            ['name' => 'role.permission.viewAny'],
            ['name' => 'role.permission.update'],
            ['name' => 'sheet.viewAny'],
            ['name' => 'sheet.view'],
            ['name' => 'sheet.create'],
            ['name' => 'sheet.delete'],
            ['name' => 'team.viewAny'],
            ['name' => 'team.view'],
            ['name' => 'team.create'],
            ['name' => 'team.update'],
            ['name' => 'team.delete'],
            ['name' => 'team.delete.force'],
            ['name' => 'team.restore'],
            ['name' => 'team.user.viewAny'],
            ['name' => 'team.user.create'],
            ['name' => 'team.user.delete'],
            ['name' => 'user.viewAny'],
            ['name' => 'user.view'],
            ['name' => 'user.create'],
            ['name' => 'user.update'],
            ['name' => 'user.delete'],
            ['name' => 'user.delete.force'],
            ['name' => 'user.restore'],
            ['name' => 'user.role.update']
        ];
        foreach ($permissions as $permission){
                Permission::firstOrCreate($permission);
        }

    }
}
