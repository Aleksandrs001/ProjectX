<?php declare(strict_types=1);

namespace App\Controllers;

use App\Template;
use App\Services\ShortsService;
use App\Services\ProfileService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class ShortsController
{
    private ListCryptoCurrenciesService $listCryptoCurrenciesService;
    private ShowCryptoCurrencyService $showCryptoCurrencyService;
    private ProfileService $profileService;

    public function __construct(
        ListCryptoCurrenciesService $listCryptoCurrenciesService,
        ShowCryptoCurrencyService $showCryptoCurrencyService,
        ProfileService $profileService
    )
    {
        $this->listCryptoCurrenciesService = $listCryptoCurrenciesService;
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
        $this->profileService = $profileService;
    }
    public function showForm(): Template
    {
        $cryptoCurrencies =  $this->listCryptoCurrenciesService->execute(
          explode(",",  $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA")
        );

        $showFromDB= new ShortsService($this->showCryptoCurrencyService);
        return  new Template("short/shorts.twig", [
            "items"=>$this->profileService->sumInWallet(),
            "start" => $cryptoCurrencies->all(),
            "finish" => $showFromDB->showAccInfo()->all()
            ]);
    }
}