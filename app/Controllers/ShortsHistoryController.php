<?php

namespace App\Controllers;

use App\Services\ProfileService;
use App\Template;
use App\Services\ShortsService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class ShortsHistoryController
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        ShowCryptoCurrencyService $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }

    public function showForm(): Template
    {
        $totalMoneyInAccount = new profileService();
        $totalMoneyInAccount = $totalMoneyInAccount->sumInWallet();
        $allTransactions = new ShortsService( $this->showCryptoCurrencyService);
        $history=$allTransactions->showHistory();
        return new Template("short/shortsHistory.twig",
            [
                "items"=>$totalMoneyInAccount,
                "userData"=>$history->all()
            ]
        );
    }
}