<?php

namespace App\Controllers;

use App\Models\BuySellServiceRequest;
use App\Post;
use App\Redirect;
use App\Services\SellService;

class SellController
{
    public function sellCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ($_POST["sellAmount"]);
        $price = $_POST["price"];
        $sellService = new BuySellServiceRequest($amount->getPost(), $userInfo["symbol"], $price);
        $startService = new SellService();

        return $startService->sellCrypto($sellService);
    }
}