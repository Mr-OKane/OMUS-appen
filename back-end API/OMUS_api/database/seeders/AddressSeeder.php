<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\ZipCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(storage_path('CSV\adresser.csv'),'r')
            ->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $offset => $record){
            if (!empty($record['supplerendebynavn'])) {
                Address::firstOrCreate([
                    'zip_code_id' => ZipCode::where('zip_code', '=', $record['postnr'])->first()->id,
                    'address' => $record['vejnavn'] . ' ' . $record['husnr'] . ', ' . $record['supplerendebynavn'],
                ]);
            }else
            {
                Address::firstOrCreate([
                    'zip_code_id' => ZipCode::where('zip_code', '=', $record['postnr'])->first()->id,
                    'address' => $record['vejnavn'] . ' ' . $record['husnr'],
                ]);
            }
        }
    }
}
