<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\ShortsRepository;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class SellShortsService
{

    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(

        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {

        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function start($postRequest): Redirect
    {
       $start= new ShortsRepository($this->showCryptoCurrencyService);
       return $start->sellShorts($postRequest);
    }
}
