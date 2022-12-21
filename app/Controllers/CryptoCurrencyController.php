<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProfileService;
use App\Template;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class CryptoCurrencyController
{
    private ListCryptoCurrenciesService $listCryptoCurrenciesService;
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ListCryptoCurrenciesService $listCryptoCurrenciesService,
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->listCryptoCurrenciesService = $listCryptoCurrenciesService;
          $this->showCryptoCurrencyService = $showCryptoCurrencyService;

    }

    public function index(): Template
    {
        $cryptoCurrencies = $this->listCryptoCurrenciesService->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA"
            )
        );
        $totalMoneyInAccount = new profileService();
        $totalMoneyInAccount = $totalMoneyInAccount->sumInWallet();
        return new Template("coinMarketApi/coinMarketApi.twig", [
            "items"=>$totalMoneyInAccount,
            'response' => $cryptoCurrencies->all()
        ]);
    }
    public function showForm(array $vars): Template
    {

        $cryptoCurrency = $this->showCryptoCurrencyService->execute(
             $vars["symbol"]
        );
        $totalMoneyInAccount = new profileService();
        $totalMoneyInAccount = $totalMoneyInAccount->sumInWallet();
        return new Template("readyToBuy/readyToBuy.twig", [
            "items"=>$totalMoneyInAccount,
            'response' => [$cryptoCurrency]
        ]);
    }
}
