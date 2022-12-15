<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\BuySellServiceRequest;
use App\Post;
use App\Redirect;
use App\Services\SellService;

class SellController
{
    public function sellCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ((float) $_POST["sellAmount"]);
        $sellService = new BuySellServiceRequest($amount->getPost(), $userInfo["symbol"]);
        $startService = new SellService();

        return $startService->sellCrypto($sellService);
    }
}