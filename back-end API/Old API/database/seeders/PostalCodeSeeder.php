<?php

namespace Database\Seeders;

use App\Models\PostalCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Shuchkin\SimpleXLS;

class PostalCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postcodes = [];
        $filelocation = realpath($_SERVER["DOCUMENT_ROOT"]).'\resources\tmp\postnumber.xls';
        $filecontent = file_get_contents("https://www.postnord.dk/globalassets/danmark/.excl-docs/postnummerfil-til-download-22-06-2021.xls");
        file_put_contents($filelocation, $filecontent);

        if ( $xls = SimpleXLS::parse($filelocation) ) {
            foreach($xls->rows() as $row){
                if($row[5] == 1){
                    array_push($postcodes, ['postalCode' => $row[0], 'city' => $row[1]]);
                    $postcodes = array_map("unserialize",array_unique(array_map("serialize",$postcodes)));
                }
            }
        } else {
            echo SimpleXLS::parseError();
        }
        foreach ($postcodes as $postcode){
            PostalCode::create($postcode);
        }
    }
}
