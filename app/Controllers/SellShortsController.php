<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\SellShortsService;
use App\Models\BuySellServiceRequest;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class SellShortsController
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function sellShorts(): Redirect
    {
        $toRequest = new BuySellServiceRequest($_POST["currency"], $_POST["amount"]);
        $start = new SellShortsService($this->showCryptoCurrencyService);
        return $start->start($toRequest);
    }
}
