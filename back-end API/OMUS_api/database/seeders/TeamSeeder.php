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
     */
    public function run(): void
    {
        $teams = [
            ['name' => 'Odense Ungdoms Synfoniorkester'],
            ['name' => 'Carl Nielsen undoms synfonyorkester'],
        ];
        foreach ($teams as $team)
        {
            Team::firstOrCreate($team);
        }
        Team::firstwhere('name','=',"Odense Ungdoms Synfoniorkester")->users()->sync(User::all());
    }
}
