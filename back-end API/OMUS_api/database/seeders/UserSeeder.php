<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\UserStatus;
use App\Models\ZipCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(storage_path('CSV\OMUS-elever.csv'),'r')
            ->setHeaderOffset(0)
            ->setDelimiter(';');
        $records = $csv->getRecords();
        $arrayValues = ['active','inactive'];

        foreach ($records as $offset => $record){
            User::firstOrCreate([
                'address_id' => Address::withTrashed()->where('zip_code_id','=',
                    ZipCode::withTrashed()->firstWhere('zip_code','=',$record['Postnr'])['id'])
                    ->inRandomOrder()->first()['id'],
                'role_id' => Role::all()->random(1)[0]['id'],
                'firstname' => explode(' ', $record['Navn'],2)[0],
                'lastname' => explode(' ', $record['Navn'], 2)[1],
                'email' => $record['Email'],
                'phone_nr' => $record['Mobil'],
                'password' => "Password1!",
                'status' => $arrayValues[rand(0,1)]
            ]);
        }
    }
}
