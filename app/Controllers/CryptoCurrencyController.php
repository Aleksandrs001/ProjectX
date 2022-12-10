<?php

namespace App\Controllers;

use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Template;

class CryptoCurrencyController
{
    public function index(): Template
    {

        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE"
            )
        );

        return new Template("coinMarketApi/coinMarketApi.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }
}
