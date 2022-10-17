<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TeamSeeder::class,
            IdeaSeeder::class,
            NotificationSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            InstrumentSeeder::class,
            UserSeeder::class,
            PracticeDateSeeder::class,
            SheetSeeder::class,
            AbsenceSeeder::class,
            MessageSeeder::class,
            ChatSeeder::class,
            ChatRoomSeeder::class,
            PostalCodeSeeder::class,
            AddressSeeder::class,
            OrderStatusSeeder::class,
            OrderSeeder::class,
            ProductSeeder::class,
            OrderProductsSeeder::class,
        ]);
    }
}
