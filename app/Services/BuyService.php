<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\BuyCryptoCurrencyRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class BuyService
{
    public function buyCrypto($buyService): Redirect
    {
        $symbol = $buyService->getSymbol();
        $amount = $buyService->getAmount();
        $repo = new BuyCryptoCurrencyRepository();
        $newConnect = new ListCryptoCurrenciesService();
        $getCoinInfo = $newConnect->execute([$symbol]);

        $requestedCoinPrice = 0;
        foreach ($getCoinInfo->all() as $getPriceFromApi) {
            $requestedCoinPrice = $getPriceFromApi->price;
        }
        return $repo->buyCryptoCurrency($requestedCoinPrice, $symbol, $amount);
    }
}