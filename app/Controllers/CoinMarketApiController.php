<?php

namespace App\Controllers;

use App\Services\CoinMarketService;
use App\Template;


class CoinMarketApiController
{
    public function showForm(): Template
    {
        $coins = (new CoinMarketService())->execute();
        return new Template("coinMarketApi/coinMarketApi.twig", ['response' => $coins->get()]);
    }
}
