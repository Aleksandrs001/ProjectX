<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\BuyShortsService;
use App\Models\BuySellServiceRequest;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class BuyShortsController
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function buyShorts(): Redirect
    {
        $toRequest = new BuySellServiceRequest($_POST["currency"], $_POST["amount"]);
        $start = new BuyShortsService($this->showCryptoCurrencyService);
        return $start->startBuy($toRequest);
    }
}