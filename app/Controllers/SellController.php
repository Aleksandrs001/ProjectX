<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Redirect;
use App\Services\SellService;
use App\Models\BuySellServiceRequest;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class SellController
{
    public ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(ShowCryptoCurrencyService $showCryptoCurrencyService)
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;


    }
    public function sellCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ((float) $_POST["sellAmount"]);
        $sellService = new BuySellServiceRequest( $userInfo["symbol"], $amount->getPost());
        $startService = new SellService($this->showCryptoCurrencyService);

        return $startService->sellCrypto($sellService);
    }
}