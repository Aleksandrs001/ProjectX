<?php

namespace App\Controllers;

use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Template;

class CryptoCurrencyController
{
    public function index(): Template
    {
        $_SERVER['session']=$_GET;
        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA"
            )
        );

        return new Template("coinMarketApi/coinMarketApi.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }
}
