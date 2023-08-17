<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\PracticeDate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NotificationSeeder::class,
            IdeaSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            InstrumentSeeder::class,
            TeamSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            PracticeDateSeeder::class,
            CakeArrengementSeeder::class,
            SheetSeeder::class,
            AbsenceSeeder::class,
            MessageSeeder::class,
            ChatSeeder::class,
            ChatRoomSeeder::class,
            CitySeeder::class,
            ZipCodeSeeder::class,
            AddressSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            ProductSeeder::class,
            OrderProductsSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
