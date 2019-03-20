<?php

use Illuminate\Database\Seeder;
use App\Market;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Market::insert(
            array(
                array(
                    "name" => "coinapi.io",
                    "link" => "https://rest.coinapi.io/v1/exchangerate/",
                    "api_key" => "C7D7FCE8-DEFE-4812-9ABC-7E783495F313"
                ),

                array(
                    "name" => "nomics.com",
                    "link" => "https://api.nomics.com/v1/currencies/",
                    "api_key" => "a9128db7756b37870993952838513bce"
                )
            )
        );
    }
}
