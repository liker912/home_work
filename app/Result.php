<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //
    protected $table = "result";

    protected $fillable = ["id", "market_id", "currency_id", "crypto_currency_code", "price_value"];

}
