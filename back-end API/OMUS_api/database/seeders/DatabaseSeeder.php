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
            CitySeeder::class,
            ZipCodeSeeder::class,
            AddressSeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
            PracticeDateSeeder::class,
            CakeArrangementSeeder::class,
            SheetSeeder::class,
            ChatRoomSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            OrderSeeder::class,
            ProductSeeder::class,
            OrderProductSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
