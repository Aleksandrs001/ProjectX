<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Redirect;
use App\Services\BuyService;
use App\Models\BuySellServiceRequest;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class BuyController
{
    public ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(ShowCryptoCurrencyService $showCryptoCurrencyService)
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }

    public function buyCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ((float) $_POST["buyAmount"]);
        $buyService = new BuySellServiceRequest( $userInfo["symbol"],$amount->getPost());
        $startService=  new BuyService($this->showCryptoCurrencyService);

        return $startService->buyCrypto($buyService);
    }
}