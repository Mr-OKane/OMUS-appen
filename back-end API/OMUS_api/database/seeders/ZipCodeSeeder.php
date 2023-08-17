<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\ZipCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class ZipCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(storage_path('CSV\Postnummer2.csv'),'r')
            ->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $offset => $record){
            ZipCode::firstOrCreate([
                'city_id' => City::where('city','=',$record['Bynavn'])->first()->id,
                'zip_code' => $record['Postnr'],
            ]);
        }
    }
}
