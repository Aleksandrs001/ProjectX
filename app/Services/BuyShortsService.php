<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\ShortsRepository;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class BuyShortsService
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function startBuy($postRequest): Redirect
    {
        $start = new ShortsRepository($this->showCryptoCurrencyService,);
        return $start->buyShorts($postRequest);
    }
}