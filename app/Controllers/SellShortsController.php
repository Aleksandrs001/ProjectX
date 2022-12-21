<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\SellShortsService;
use App\Models\BuySellServiceRequest;

class SellShortsController
{
    public function sellShorts(): Redirect
    {
        $toRequest = new BuySellServiceRequest($_POST["currency"], $_POST["amount"]);
        $start = new SellShortsService();
        return $start->start($toRequest);
    }
}
