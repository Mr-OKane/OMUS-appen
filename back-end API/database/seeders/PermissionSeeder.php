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
            ['name' => 'absence.create'],
            ['name' => 'absence.delete'],
            ['name' => 'address.viewAny'],
            ['name' => 'address.create'],
            ['name' => 'address.view'],
            ['name' => 'address.update'],
            ['name' => 'address.delete'],
            ['name' => 'chat.viewAny'],
            ['name' => 'chat.deleted.viewAny'],
            ['name' => 'chat.create'],
            ['name' => 'chat.view'],
            ['name' => 'chat.update'],
            ['name' => 'chat.delete'],
            ['name' => 'chat.delete.force'],
            ['name' => 'chat.restore'],
            ['name' => 'chatroom.viewAny'],
            ['name' => 'chatroom.deleted.viewAny'],
            ['name' => 'chatroom.create'],
            ['name' => 'chatroom.view'],
            ['name' => 'chatroom.update'],
            ['name' => 'chatroom.delete'],
            ['name' => 'chatroom.delete.force'],
            ['name' => 'chatroom.restore'],
            ['name' => 'idea.viewAny'],
            ['name' => 'idea.create'],
            ['name' => 'idea.view'],
            ['name' => 'idea.update'],
            ['name' => 'idea.delete'],
            ['name' => 'instrument.viewAny'],
            ['name' => 'instrument.deleted.viewAny'],
            ['name' => 'instrument.create'],
            ['name' => 'instrument.view'],
            ['name' => 'instrument.update'],
            ['name' => 'instrument.delete'],
            ['name' => 'instrument.delete.force'],
            ['name' => 'instrument.restore'],
            ['name' => 'message.viewAny'],
            ['name' => 'message.create'],
            ['name' => 'message.view'],
            ['name' => 'message.update'],
            ['name' => 'message.delete'],
            ['name' => 'notification.viewAny'],
            ['name' => 'notification.create'],
            ['name' => 'notification.view'],
            ['name' => 'notification.update'],
            ['name' => 'notification.delete'],
            ['name' => 'order.viewAny'],
            ['name' => 'order.deleted.viewAny'],
            ['name' => 'order.create'],
            ['name' => 'order.view'],
            ['name' => 'order.update'],
            ['name' => 'order.delete'],
            ['name' => 'order.delete.force'],
            ['name' => 'order.restore'],
            ['name' => 'orderstatus.viewAny'],
            ['name' => 'orderstatus.create'],
            ['name' => 'orderstatus.view'],
            ['name' => 'orderstatus.update'],
            ['name' => 'orderstatus.delete'],
            ['name' => 'permission.viewAny'],
            ['name' => 'postalcode.viewAny'],
            ['name' => 'postalcode.view'],
            ['name' => 'practicedate.viewAny'],
            ['name' => 'practicedate.create'],
            ['name' => 'practicedate.view'],
            ['name' => 'practicedate.update'],
            ['name' => 'practicedate.delete'],
            ['name' => 'product.viewAny'],
            ['name' => 'product.deleted.viewAny'],
            ['name' => 'product.create'],
            ['name' => 'product.view'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],
            ['name' => 'product.delete.force'],
            ['name' => 'product.restore'],
            ['name' => 'role.viewAny'],
            ['name' => 'role.deleted.viewAny'],
            ['name' => 'role.permission.viewAny'],
            ['name' => 'role.create'],
            ['name' => 'role.view'],
            ['name' => 'role.update'],
            ['name' => 'role.permission.update'],
            ['name' => 'role.delete'],
            ['name' => 'role.delete.force'],
            ['name' => 'role.restore'],
            ['name' => 'sheet.viewAny'],
            ['name' => 'sheet.deleted.viewAny'],
            ['name' => 'sheet.create'],
            ['name' => 'sheet.view'],
            ['name' => 'sheet.delete'],
            ['name' => 'sheet.delete.force'],
            ['name' => 'sheet.restore'],
            ['name' => 'team.viewAny'],
            ['name' => 'team.deleted.viewAny'],
            ['name' => 'team.user.viewAny'],
            ['name' => 'team.create'],
            ['name' => 'team.view'],
            ['name' => 'team.update'],
            ['name' => 'team.user.update'],
            ['name' => 'team.delete'],
            ['name' => 'team.delete.force'],
            ['name' => 'team.restore'],
            ['name' => 'user.viewAny'],
            ['name' => 'user.deleted.viewAny'],
            ['name' => 'user.create'],
            ['name' => 'user.view'],
            ['name' => 'user.update'],
            ['name' => 'user.password.update'],
            ['name' => 'user.role.update'],
            ['name' => 'user.Instrument.update'],
            ['name' => 'user.delete'],
            ['name' => 'user.delete.force'],
            ['name' => 'user.restore'],
        ];
        foreach ($permissions as $permission){
                Permission::firstOrCreate($permission);
        }

    }
}
