<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Absence;
use App\Models\Address;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Idea;
use App\Models\Instrument;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Permission;
use App\Models\PostalCode;
use App\Models\PracticeDate;
use App\Models\Product;
use App\Models\Role;
use App\Models\Sheet;
use App\Models\Team;
use App\Models\User;
use App\Policies\AbsencePolicy;
use App\Policies\AddressPolicy;
use App\Policies\ChatPolicy;
use App\Policies\ChatRoomPolicy;
use App\Policies\IdeaPolicy;
use App\Policies\InstrumentPolicy;
use App\Policies\MessagePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OrderStatusPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostalCodePolicy;
use App\Policies\PracticeDatePolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SheetPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Services\Auth\JwtGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Absence::class => AbsencePolicy::class,
        Address::class => AddressPolicy::class,
        Chat::class => ChatPolicy::class,
        ChatRoom::class => ChatRoomPolicy::class,
        Idea::class => IdeaPolicy::class,
        Instrument::class => InstrumentPolicy::class,
        Message::class => Message::class,
        Notification::class => NotificationPolicy::class,
        Order::class => OrderPolicy::class,
        OrderStatus::class => OrderStatusPolicy::class,
        Permission::class => PermissionPolicy::class,
        PostalCode::class => PostalCodePolicy::class,
        PracticeDate::class => PracticeDatePolicy::class,
        Product::class => ProductPolicy::class,
        Role::class => RolePolicy::class,
        Sheet::class => SheetPolicy::class,
        Team::class => TeamPolicy::class,
        User::class => UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //absence
        Gate::define('absence.viewAny', [AbsencePolicy::class,'viewAny']);
        Gate::define('absence.create', [AbsencePolicy::class, 'create']);
        Gate::define('absence.delete', [AbsencePolicy::class, 'delete']);

        //Address
        Gate::define('address.viewAny', [AddressPolicy::class, 'viewAny']);
        Gate::define('address.view', [AddressPolicy::class, 'view']);
        Gate::define('address.create', [AddressPolicy::class,'create']);
        Gate::define('address.update', [AddressPolicy::class, 'update']);
        Gate::define('address.delete',[AddressPolicy::class, 'delete']);

        //chat
        Gate::define('chat.viewAny',[ChatPolicy::class, 'viewAny']);
        Gate::define('chat.deleted.viewAny', [ChatPolicy::class, 'deleted']);
        Gate::define('chat.view', [ChatPolicy::class, 'view']);
        Gate::define('chat.create', [ChatPolicy::class, 'create']);
        Gate::define('chat.update', [ChatPolicy::class, 'update']);
        Gate::define('chat.delete', [ChatPolicy::class, 'delete']);
        Gate::define('chat.delete.force', [ChatPolicy::class, 'forceDelete']);
        Gate::define('chat.restore', [ChatPolicy::class, 'restore']);

        //Chat room
        Gate::define('chatroom.viewAny', [ChatRoomPolicy::class, 'viewAny']);
        Gate::define('chatroom.deleted.viewAny', [ChatRoomPolicy::class, 'deleted']);
        Gate::define('chatroom.view', [ChatRoomPolicy::class, 'view']);
        Gate::define('chatroom.create', [ChatRoomPolicy::class, 'create']);
        Gate::define('chatroom.update', [ChatRoomPolicy::class, 'update']);
        Gate::define('chatroom.delete', [ChatRoomPolicy::class, 'delete']);
        Gate::define('chatroom.delete.force', [ChatRoomPolicy::class, 'forceDelete']);
        Gate::define('chatroom.restore', [ChatRoomPolicy::class, 'restore']);

        //Idea
        Gate::define('idea.viewAny', [IdeaPolicy::class, 'viewAny']);
        Gate::define('idea.view', [IdeaPolicy::class, 'view']);
        Gate::define('idea.create', [IdeaPolicy::class, 'create']);
        Gate::define('idea.update', [IdeaPolicy::class, 'update']);
        Gate::define('idea.delete', [IdeaPolicy::class, 'delete']);

        //Instrument
        Gate::define('insturment.viewAny', [InstrumentPolicy::class,'viewAny']);
        Gate::define('instrument.deleted.viewAny', [InstrumentPolicy::class, 'deleted']);
        Gate::define('instrument.view', [InstrumentPolicy::class, 'view']);
        Gate::define('instrument.create', [InstrumentPolicy::class, 'create']);
        Gate::define('instrument.update', [InstrumentPolicy::class, 'update']);
        Gate::define('instrument.delete', [InstrumentPolicy::class, 'delete']);
        Gate::define('instrument.delete.force', [InstrumentPolicy::class, 'forceDelete']);
        Gate::define('instrument.restore', [InstrumentPolicy::class, 'restore']);


        //Messsage
        Gate::define('message.viewAny', [MessagePolicy::class,'viewAny']);
        Gate::define('message.view', [MessagePolicy::class, 'view']);
        Gate::define('message.create', [MessagePolicy::class, 'create']);
        Gate::define('message.update', [MessagePolicy::class, 'update']);
        Gate::define('message.delete', [MessagePolicy::class, 'delete']);

        //Notification
        Gate::define('notification.viewAny', [NotificationPolicy::class, 'viewAny']);
        Gate::define('notification.view', [NotificationPolicy::class, 'view']);
        Gate::define('notification.create', [NotificationPolicy::class, 'create']);
        Gate::define('notidication.update', [NotificationPolicy::class, 'update']);
        Gate::define('notification.delete',[NotificationPolicy::class, 'delete']);

        //Order
        Gate::define('order.viewAmy', [OrderPolicy::class,'viewAny']);
        Gate::define('order.deleted.viewAny', [OrderPolicy::class, 'deleted']);
        Gate::define('order.view', [OrderPolicy::class, 'view']);
        Gate::define('order.create', [OrderPolicy::class, 'create']);
        Gate::define('order.update',[OrderPolicy::class,'update']);
        Gate::define('order.delete', [OrderPolicy::class, 'delete']);
        Gate::define('order.delete.force', [OrderPolicy::class, 'forceDelete']);
        Gate::define('order.restore', [OrderPolicy::class, 'restore']);

        //Order status
        Gate::define('orderstatus.viewAny',[OrderStatusPolicy::class, 'viewAny']);
        Gate::define('orderstatus.view', [OrderStatusPolicy::class, 'view']);
        Gate::define('orderstatus.create', [OrderStatusPolicy::class, 'create']);
        Gate::define('orderstatus.update', [OrderStatusPolicy::class, 'update']);
        Gate::define('orderstatus.delete', [OrderStatusPolicy::class, 'delete']);

        //Permission
        Gate::define('permission.viewAny', [PermissionPolicy::class, 'viewAny']);

        //Postal code
        Gate::define('postalcode.viewAny', [PostalCodePolicy::class, 'viewAny']);
        Gate::define('postalcode.view', [PostalCodePolicy::class, 'view']);

        //Practice date
        Gate::define('practicedate.viewAny', [PracticeDatePolicy::class, 'viewAny']);
        Gate::define('practicedate.view', [PracticeDatePolicy::class, 'view']);
        Gate::define('practicedate.create', [PracticeDatePolicy::class, 'create']);
        Gate::define('practicedate.update', [PracticeDatePolicy::class, 'update']);
        Gate::define('practicedate.delete', [PracticeDatePolicy::class, 'delete']);

        //Product
        Gate::define('product.viewAny', [ProductPolicy::class, 'viewAny']);
        Gate::define('product.deleted.viewAny', [ProductPolicy::class, 'deleted']);
        Gate::define('product.view', [ProductPolicy::class, 'view']);
        Gate::define('product.create', [ProductPolicy::class, 'create']);
        Gate::define('product.update', [ProductPolicy::class, 'update']);
        Gate::define('product.delete', [ProductPolicy::class, 'delete']);
        Gate::define('product.delete.force', [ProductPolicy::class, 'forceDelete']);
        Gate::define('product.restore', [ProductPolicy::class, 'restore']);


        //Role
        Gate::define('role.viewAny', [RolePolicy::class, 'viewAny']);
        Gate::define('role.deleted.viewAny', [RolePolicy::class, 'deleted']);
        Gate::define('role.permission.viewAny', [RolePolicy::class, 'permissionViewAny']);
        Gate::define('role.view', [RolePolicy::class, 'view']);
        Gate::define('role.create', [RolePolicy::class, 'create']);
        Gate::define('role.update', [RolePolicy::class, 'update']);
        Gate::define('role.permission.update', [RolePolicy::class, 'updatePermission']);
        Gate::define('role.delete', [RolePolicy::class, 'delete']);
        Gate::define('role.delete.force', [RolePolicy::class, 'forceDelete']);
        Gate::define('role.restore', [RolePolicy::class, 'restore']);

        //Sheet
        Gate::define('sheet.viewAny', [SheetPolicy::class, 'viewAny']);
        Gate::define('sheet.deleted.viewAny', [SheetPolicy::class, 'deleted']);
        Gate::define('sheet.view', [SheetPolicy::class, 'view']);
        Gate::define('sheet.create', [SheetPolicy::class, 'create']);
        Gate::define('sheet.update', [SheetPolicy::class, 'update']);
        Gate::define('sheet.delete', [SheetPolicy::class, 'delete']);
        Gate::define('sheet.delete.force', [SheetPolicy::class, 'forceDelete']);
        Gate::define('sheet.restore', [SheetPolicy::class, 'restore']);

        //Team
        Gate::define('team.viewAny', [TeamPolicy::class,'viewAny']);
        Gate::define('team.deleted.viewAny', [TeamPolicy::class, 'deleted']);
        Gate::define('team.user.viewAny', [TeamPolicy::class, 'teamUserViewAny']);
        Gate::define('team.view', [TeamPolicy::class,'view']);
        Gate::define('team.create', [TeamPolicy::class,'create']);
        Gate::define('team.user.update', [TeamPolicy::class, 'teamUserCreate']);
        Gate::define('team.update', [TeamPolicy::class, 'update']);
        Gate::define('team.delete', [TeamPolicy::class, 'delete']);
        Gate::define('team.delete.force', [TeamPolicy::class, 'forceDelete']);
        Gate::define('team.restore', [TeamPolicy::class, 'restore']);

        //user
        Gate::define('user.viewAny',[UserPolicy::class,'viewAny']);
        Gate::define('user.deleted.viewAny',[UserPolicy::class,'deleted']);
        Gate::define('user.view',[UserPolicy::class,'view']);
        Gate::define('user.create',[UserPolicy::class,'create']);
        Gate::define('user.update',[UserPolicy::class, 'update']);
        Gate::define('user.password.update',[UserPolicy::class, 'passwordUpdate']);
        Gate::define('user.role.update',[UserPolicy::class, 'userRoleUpdate']);
        Gate::define('user.instrument.update',[UserPolicy::class, 'instrumentUpdate']);
        Gate::define('user.delete',[UserPolicy::class, 'delete']);
        Gate::define('user.restore',[UserPolicy::class, 'restore']);
        Gate::define('user.delete.force',[UserPolicy::class,'forceDelete']);

        Auth::viaRequest('custom-token', function (Request $request) {
            return User::where('token', $request->token)->first();
        });
/*
      Auth::extend('jwt', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            return new JwtGuard(Auth::createUserProvider($config['provider']));
        });
*/
    }
}
