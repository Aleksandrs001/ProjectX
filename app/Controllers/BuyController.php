<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Redirect;
use App\Services\BuyService;
use App\Models\BuySellServiceRequest;

class BuyController
{

    public function buyCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ((float) $_POST["buyAmount"]);
        $buyService = new BuySellServiceRequest($amount->getPost(), $userInfo["symbol"]);
        $startService=  new BuyService();

        return $startService->buyCrypto($buyService);
    }
}