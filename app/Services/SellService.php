<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\SellCryptoCurrencyRepository;

class SellService
{
    public function sellCrypto($sellService): Redirect
    {

        $price=$sellService->getPrice();
        $symbol= $sellService->getSymbol();
        $amount= $sellService->getAmount();
        $repo= new SellCryptoCurrencyRepository();

        return  $repo->sellCryptoCurrency($price,$symbol,$amount);
    }
}