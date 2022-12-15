<?php declare(strict_types=1);

namespace App\Controllers;

use App\Template;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class CryptoCurrencyController
{
    public function index(): Template
    {
        $_SERVER['session']=$_GET;
        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA"
            )
        );

        return new Template("coinMarketApi/coinMarketApi.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }
    public function showForm(array $vars): Template
    {
        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $vars["symbol"]
            )
        );
        return new Template("readyToBuy/readyToBuy.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }
}
