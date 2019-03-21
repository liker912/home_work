<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    //
    protected $table = "result";

    protected $fillable = ["id", "market_id", "currency_id", "crypto_currency_code", "price_value"];

    // relation to Market model
    public function market()
    {
        return $this->belongsTo('App\Market', 'market_id');
    }

    // relation to Currency model
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currency_id');
    }
}
