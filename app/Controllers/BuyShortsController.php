<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\BuyShortsService;
use App\Models\BuySellServiceRequest;

class BuyShortsController
{
    public function buyShorts(): Redirect
    {
        $toRequest = new BuySellServiceRequest($_POST["currency"], $_POST["amount"]);
        $start = new BuyShortsService();
        return $start->startBuy($toRequest);
    }
}