<?php

namespace App\Services;

use App\Repositories\ShortsRepository;
use App\Models\Collections\CryptoCurrenciesCollection;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class ShortsService
{

    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(

        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {

        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }


    public function showAccInfo(): CryptoCurrenciesCollection
    {
        $start= new ShortsRepository($this->showCryptoCurrencyService);
        return $start->showAccInfo();
    }

     public function showHistory(): CryptoCurrenciesCollection
     {
        $start= new ShortsRepository($this->showCryptoCurrencyService);
        return $start->showHistory();
    }
}
