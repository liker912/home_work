<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Events\CurrenciesSent;
use App\Events\ErrorSent;
use App\Events\MarketsSent;
use App\Market;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
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


    /**
     * Get all markets from database and send it via web socket
     *
     */
    public function sendMarkets()
    {
        try {
            $markets = Market::all();
            event(new MarketsSent($markets));

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


    public function sendResult(int $marketId, int $currencyId)
    {
        try {
            $client = new Client();
            $market = Market::find($marketId);
            $currency = Currency::find($currencyId);
            $link = sprintf($market->link, $currency->code, $market->api_key);


            $request = new Request('GET', $link);
            $promise = $client->sendAsync($request)->then(function ($response) {
                echo $response->getBody();
            });
            $promise->wait();

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
}
