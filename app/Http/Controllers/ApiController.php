<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Events\CurrenciesSent;
use App\Events\ErrorSent;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    
    /**
     * Get all currency from database and send it via web socket
     *
     */
    public function sendCurrencies()
    {
        try {
            $currencies = Currency::all();
            event(new CurrenciesSent($currencies));

        } catch (\Exception $e) {
            event(
                new ErrorSent(
                    array(
                        "message" => $e->getMessage(),
                        "code" => $e->getCode()
                    )
                )
            );
        }
    }


    public function getCurrencyFromMarket(String $market, String $currency): JsonResponse
    {
        $currency = array(array($currency => "234"));
    }
}
