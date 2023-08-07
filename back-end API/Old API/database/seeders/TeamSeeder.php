<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['name' => "OMUS"],
            ['name' => "CNUS"]
        ];

        foreach ($teams as $team){
            Team::create($team);
        }
        Team::firstWhere('name','=','OMUS')->users()->sync(User::all());
    }
}
