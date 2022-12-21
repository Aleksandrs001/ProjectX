<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\BuySellCryptoCurrencyRepository;
use App\Repositories\SellCryptoCurrencyRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class SellService
{
    public ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct( $showCryptoCurrencyService)
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;

    }
    public function sellCrypto($sellService): Redirect
    {

        $symbol = $sellService->getSymbol();
        $amount = $sellService->getAmount();
        $repo = new BuySellCryptoCurrencyRepository();
        $getCoinInfo = $this->showCryptoCurrencyService->execute($symbol)->getPrice();

        return $repo->sellCryptoCurrency($getCoinInfo, $symbol, $amount);
    }
}