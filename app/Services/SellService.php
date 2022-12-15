<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\SellCryptoCurrencyRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class SellService
{
    public function sellCrypto($sellService): Redirect
    {

        $symbol = $sellService->getSymbol();
        $amount = $sellService->getAmount();
        $repo = new SellCryptoCurrencyRepository();
        $newConnect = new ListCryptoCurrenciesService();
        $getCoinInfo = $newConnect->execute([$symbol]);

        $requestedCoinPrice = 0;
        foreach ($getCoinInfo->all() as $getPriceFromApi) {
            $requestedCoinPrice = $getPriceFromApi->price;
        }

        return $repo->sellCryptoCurrency($requestedCoinPrice, $symbol, $amount);
    }
}