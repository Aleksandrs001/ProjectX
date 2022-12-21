<?php

namespace App\Services;

use App\Redirect;
use App\Repositories\ShortsRepository;

class SellShortsService
{
    public function start($postRequest): Redirect
    {
       $start= new ShortsRepository();
       return $start->sellShorts($postRequest);
    }
}
