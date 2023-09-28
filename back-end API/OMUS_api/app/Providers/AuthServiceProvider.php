<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\City;
use App\Models\Idea;
use App\Models\Instrument;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Order;
use App\Models\PracticeDate;
use App\Models\Product;
use App\Models\Role;
use App\Models\Status;
use App\Models\Team;
use App\Models\User;
use App\Models\ZipCode;
use App\Policies\AddressPolicy;
use App\Policies\ChatPolicy;
use App\Policies\ChatRoomPolicy;
use App\Policies\CityPolicy;
use App\Policies\IdeaPolicy;
use App\Policies\InstrumentPolicy;
use App\Policies\MessagePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PracticeDatePolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\StatusPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use App\Policies\ZipCodePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        Chat::class => ChatPolicy::class,
        ChatRoom::class => ChatRoomPolicy::class,
        City::class => CityPolicy::class,
        Idea::class => IdeaPolicy::class,
        Instrument::class => InstrumentPolicy::class,
        Message::class => MessagePolicy::class,
        Notification::class => NotificationPolicy::class,
        Order::class => OrderPolicy::class,
        PracticeDate::class => PracticeDatePolicy::class,
        Product::class => ProductPolicy::class,
        Role::class => RolePolicy::class,
        Team::class => TeamPolicy::class,
        User::class => UserPolicy::class,
        ZipCode::class => ZipCodePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}
