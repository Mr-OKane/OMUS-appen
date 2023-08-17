<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = "";
        $csv = Reader::createFromPath(storage_path('CSV\Postnummer2.csv'),'r+')
            ->setHeaderOffset(0);

        $records = $csv->getRecords();
        foreach ($records as $offset => $record){
            if($city != $record['Bynavn']){
                City::firstOrCreate([
                    'city' => $record['Bynavn'],
                ]);
                $city = $record['Bynavn'];
            }
        }
    }
}
