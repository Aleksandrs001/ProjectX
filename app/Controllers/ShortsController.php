<?php

namespace App\Controllers;

use App\Template;
use App\Services\ShortsService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class ShortsController
{
    public array $start;

    public function showForm(): Template
    {
        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA"));

        $showFromDB= new ShortsService();
        return  new Template("short/short.twig", [
            "start" => $cryptoCurrencies->all(),
            "finish" => $showFromDB->showAccInfo()->all()
            ]);
    }
}
