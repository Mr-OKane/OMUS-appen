<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Shuchkin\SimpleXLSX;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $usersStr = [];
        $fileData = file_get_contents(realpath($_SERVER["DOCUMENT_ROOT"]).'\resources\OMUS-elever.csv');
        $users = preg_split("/\r\n/", $fileData);
        foreach ($users as $userStr) {
            $user = preg_split("/;+/", $userStr);
            $user;
        }*/
        User::firstOrCreate([
            'firstname' => "John",
            'lastname' => "Dllrman",
            'email' => 'johnD@gmail.com',
            'password' => 'Aa123456&',
            'instrumentID' => Instrument::all()->random(1)[0]["id"],
            'roleID' => 1
        ]);

        User::firstOrCreate([
            'firstname' => "lucifer",
            'lastname' => "morningstar",
            'email' => 'lucistar@gmail.com',
            'password' => 'Aa123456&',
            'instrumentID' => Instrument::all()->random(1)[0]["id"],
            'roleID' => 1
        ]);

        User::firstOrCreate([
        'firstname' => "Izuku",
        'lastname' => "Midoriya",
        'email' => 'midoriya@gmail.com',
        'password' => 'Aa123456&',
        'instrumentID' => Instrument::all()->random(1)[0]["id"],
        'roleID' => 1
        ]);

        User::firstOrCreate([
            'firstname' => "Katsuki",
            'lastname' => "Bakugo",
            'email' => 'bakugo@gmail.com',
            'password' => 'Aa123456&',
            'instrumentID' => Instrument::all()->random(1)[0]["id"],
            'roleID' => 1
        ]);

        User::firstOrCreate([
            'firstname' => "Shoto",
            'lastname' => "Todoroki",
            'email' => 'todoroki@gmail.com',
            'password' => 'Aa123456&',
            'instrumentID' => Instrument::all()->random(1)[0]["id"],
            'roleID' => 1
        ]);

        User::firstOrCreate([
            'firstname' => "Tenya",
            'lastname' => "Iida",
            'email' => 'iida@gmail.com',
            'password' => 'Aa123456&',
            'instrumentID' => Instrument::all()->random(1)[0]["id"],
            'roleID' => 1
        ]);
    }
}
