<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\BuyCryptoCurrencyRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class BuyService
{


    public ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(ShowCryptoCurrencyService $showCryptoCurrencyService)
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;


    }

    public function buyCrypto($buyService): Redirect
    {
        $symbol = $buyService->getSymbol();
        $amount = $buyService->getAmount();
        $repo = new BuyCryptoCurrencyRepository();
        $getCoinInfo = $this->showCryptoCurrencyService->execute($symbol)->getPrice();
        return $repo->buyCryptoCurrency($getCoinInfo, $symbol, $amount);
    }
}