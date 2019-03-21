<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Currency::insert(
            array(
                array(
                    "code" => "USD"
                ),

                array(
                    "code" => "EUR"
                ),

                array(
                    "code" => "GBP"
                ),
            )
        );
    }
}
