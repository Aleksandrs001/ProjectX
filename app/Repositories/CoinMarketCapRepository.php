<?php

namespace App\Repositories;

use Dotenv\Dotenv;

class CoinMarketCapRepository
{

    public $apiData;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('dotenv');

        $url = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';
        $parameters = [
//            'id=1',
            'id' => '1,2,3,4,5,6,7,8,9,10',
//            'start' => '1',
//            'limit' => '100'
//            'convert'=> 'EUR'
//           'sort' => 'id',
        ];

        $headers = [
            'Accepts: application/json',
//            "X-CMC_PRO_API_KEY: {$dotenv->load()["SECRET_KEY"]}"
            "X-CMC_PRO_API_KEY: {$dotenv->load()["SECRET_KEY"]}"
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
// Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $this->apiData = $apiData[] = json_decode($response); // print json decoded response
        curl_close($curl); // Close request

        return $apiData;
    }

    public function getCoinMarketData()
    {
        return $this->apiData;
    }
}

