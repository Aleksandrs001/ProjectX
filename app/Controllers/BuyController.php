<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\BuySellServiceRequest;
use App\Post;
use App\Redirect;
use App\Services\BuyService;

class BuyController
{

    public function buyCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ( $_POST["buyAmount"]);
        $price = $_POST["price"];
        $buyService = new BuySellServiceRequest($amount->getPost(), $userInfo["symbol"], $price);
        $startService=  new BuyService();

        return $startService->buyCrypto($buyService);
    }
}