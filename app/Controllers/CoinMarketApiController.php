<?php

namespace App\Controllers;

use App\Services\CoinMarketService;
use App\Template;


class CoinMarketApiController
{
    public function showForm(): Template
    {
        $aa = (new CoinMarketService())->execute();
        return new Template("coinMarketApi/coinMarketApi.twig", ['response' => $aa->get()]);
    }
}

