<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Events\ErrorSent;
use App\Events\ResultSent;
use App\Helpers\MarketsParser;
use App\Http\Resources\CurrencyCollection;
use App\Http\Resources\MarketCollection;
use App\Result;
use App\Market;
use GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use App\Helpers\Logs;

class ApiController extends Controller
{

    /**
     * Get currencies from db
     *
     * @return CurrencyCollection|\Illuminate\Http\JsonResponse
     */
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


    /**
     * Get markets from db
     *
     * @return MarketCollection|\Illuminate\Http\JsonResponse
     */
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


    /**
     * Get params from client, send get request to market api link, got response, read it, save to db
     * and send new response to client via websocket
     *
     * @param int $marketId
     * @param int $currencyId
     */
    public function sendResult(int $marketId, int $currencyId)
    {
        try {
            $client = new Client();
            $market = Market::find($marketId);
            $currency = Currency::find($currencyId);
            $link = sprintf($market->link, $currency->code, $market->api_key);

            $request = new Request('GET', $link);
            $promise = $client->sendAsync($request)
                ->then(function ($response) use ($market, $currency) {
                    $result = MarketsParser::prepare($currency->id, $market->id, $response->getBody());
                    Result::insert($result);

                    // write to logs
                    Logs::getInstance()->writeToLog('Results got successfully and saved to db');

                    event(new ResultSent($result, $market->name, $currency->code));
                });
            $promise->wait();

        } catch (\Exception $e) {

            // write to logs
            Logs::getInstance()->writeToLog($e->getMessage());
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
