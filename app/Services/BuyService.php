<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\BuyCryptoCurrencyRepository;

class BuyService
{
    public function buyCrypto($buyService): Redirect
    {

     $price=$buyService->getPrice();
       $symbol= $buyService->getSymbol();
       $amount= $buyService->getAmount();


      $repo= new BuyCryptoCurrencyRepository();

return  $repo->buyCryptoCurrency($price,$symbol,$amount);
    }
}