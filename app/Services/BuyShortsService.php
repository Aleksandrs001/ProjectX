<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\ShortsRepository;

class BuyShortsService
{
    public function startBuy($postRequest): Redirect
    {
        $start = new ShortsRepository();
        return $start->buyShorts($postRequest);
    }
}