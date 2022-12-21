<?php

namespace App\Controllers;

use App\Template;
use App\Services\ShortsService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class ShortsController
{
    private ListCryptoCurrenciesService $listCryptoCurrenciesService;
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ListCryptoCurrenciesService $listCryptoCurrenciesService,
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->listCryptoCurrenciesService = $listCryptoCurrenciesService;
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function showForm(): Template
    {
        $cryptoCurrencies =  $this->listCryptoCurrenciesService->execute(
          explode(",",  $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA")
        );

        $showFromDB= new ShortsService($this->showCryptoCurrencyService);
        return  new Template("short/short.twig", [
            "start" => $cryptoCurrencies->all(),
            "finish" => $showFromDB->showAccInfo()->all()
            ]);
    }
}
