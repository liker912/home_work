<?php
/**
 * Created by PhpStorm.
 * User: liker
 * Date: 21/03/2019
 * Time: 11:10
 */

namespace App\Helpers;


use Carbon\Carbon;

/**
 * Class MarketsParser - Parse json response from markets
 *
 * @package App\Helpers
 */
class MarketsParser
{
    /**
     * Helper function for reading response from markets and preapare structure for saving to db and sending to client
     *
     * @param int    $currencyId - id of currency
     * @param int    $marketId   - id of market
     * @param String $response   - response from market
     *
     * @return array
     */
    public static function prepare(int $currencyId, int $marketId, String $response)
    {
        $limit = env('MAX_RESULT_COUNT');
        $step = 0;
        $result = array();
        $response = json_decode($response);
        $rates = $response;

        // checking if root is not array
        if (isset($response->rates)) {
            $rates = $response->rates;
        }

        foreach ($rates as $rate) {
            $cryptoCurrency = array(
                "market_id" => $marketId,
                "currency_id" => $currencyId,
                "crypto_currency_code" => self::getValueFromMarketByParam('crypto_currency_code', $marketId, $rate),
                "price_value" => self::getValueFromMarketByParam('price_value', $marketId, $rate),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            );

            if ($step < $limit) {
                array_push($result, $cryptoCurrency);
                $step++;
            } else {
                break;
            }
        }

        return $result;
    }


    /**
     * Because markets has different structure and column names I created helper function for
     * reading specific column like currency code and currency price
     *
     * @param String $param     - parameter for searching in response for example price or crypto currency name
     * @param int    $market_id - id of market
     * @param        $rate      - link to object
     *
     * @return null
     */
    private static function getValueFromMarketByParam(String $param, int $market_id, &$rate)
    {
        $marketValue = null;
        switch ($market_id) {
            case 1:
                switch ($param) {
                    case 'crypto_currency_code':
                        $marketValue = $rate->asset_id_quote;
                        break;
                    case 'price_value':
                        $marketValue = $rate->rate;
                        break;
                }
                break;
            case 2:
                switch ($param) {
                    case 'crypto_currency_code':
                        $marketValue = $rate->currency;
                        break;
                    case 'price_value':
                        $marketValue = $rate->price;
                        break;
                }
                break;
        }

        return $marketValue;
    }
}