<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Events\ErrorSent;
use App\Http\Resources\CurrencyCollection;
use App\Http\Resources\MarketCollection;
use App\Market;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use App\Helpers\Logs;

class ApiController extends Controller
{


    public function getCurrencies()
    {
        try {
            $currencies = Currency::all();

            // write to logs
            Logs::getInstance()->writeToLog("Get currency successfully");
            return new CurrencyCollection($currencies);

        } catch (\Exception $e) {
            $response = array("message" => $e->getMessage(), "code" => $e->getCode());

            // write to logs
            Logs::getInstance()->writeToLog($e->getMessage());
            return response()->json($response, 500);
        }
    }


    public function getMarkets()
    {
        try {
            $markets = Market::all();

            // write to logs
            Logs::getInstance()->writeToLog("Get currency successfully");
            return new MarketCollection($markets);
            
        } catch (\Exception $e) {
            $response = array("message" => $e->getMessage(), "code" => $e->getCode());

            // write to logs
            Logs::getInstance()->writeToLog($e->getMessage());
            return response()->json($response, 500);
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
