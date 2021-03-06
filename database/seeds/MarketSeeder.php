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
                    "link" => "https://rest.coinapi.io/v1/exchangerate/%s?apikey=%s",
                    "api_key" => "B751EE23-03E6-4AB3-9EC2-DBA7F4B395E8"
                ),

                array(
                    "name" => "nomics.com",
                    "link" => "https://api.nomics.com/v1/currencies/ticker?quote-currency=%s&key=%s",
                    "api_key" => "a9128db7756b37870993952838513bce"
                )
            )
        );
    }
}
