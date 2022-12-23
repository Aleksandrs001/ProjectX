<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProfileService;
use App\Session;
use App\Template;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;

class CryptoCurrencyController
{
    private ListCryptoCurrenciesService $listCryptoCurrenciesService;
    private ShowCryptoCurrencyService $showCryptoCurrencyService;
    private ProfileService $profileService;
    private HistoryController $historyController;

    public function __construct(
        ListCryptoCurrenciesService $listCryptoCurrenciesService,
        ShowCryptoCurrencyService $showCryptoCurrencyService,
        ProfileService $profileService,
        HistoryController $historyController
    )
    {
        $this->listCryptoCurrenciesService = $listCryptoCurrenciesService;
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
        $this->profileService = $profileService;
        $this->historyController = $historyController;
    }

    public function index(): Template
    {
        $cryptoCurrencies = $this->listCryptoCurrenciesService->execute(
            explode(",", $_GET["symbols"] ?? "BTC,ETH,LTC,DOGE,XRP,BCH,USDT,BSV,BNB,ADA"
            )
        );
        return new Template("coinMarketApi/coinMarketApi.twig", [
            "items"=>$this->profileService->sumInWallet(),
            'response' => $cryptoCurrencies->all()
        ]);
    }
    public function showForm(array $vars): Template
    {

        $cryptoCurrency = $this->showCryptoCurrencyService->execute(
             $vars["symbol"]
        );
        return new Template("readyToBuy/readyToBuy.twig", [
            "items"=>$this->profileService->sumInWallet(),
            "response" => [$cryptoCurrency],
            "showSymbolAmountAndPrice"=> $this->historyController->showSymbolAmountAndPrice()->all()
        ]);
    }
}
