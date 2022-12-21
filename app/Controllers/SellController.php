<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Redirect;
use App\Services\SellService;
use App\Models\BuySellServiceRequest;

class SellController
{
    public function sellCryptoCurrency($userInfo): Redirect
    {
        $amount = new Post ((float) $_POST["sellAmount"]);
        $sellService = new BuySellServiceRequest( $userInfo["symbol"], $amount->getPost());
        $startService = new SellService();

        return $startService->sellCrypto($sellService);
    }
}