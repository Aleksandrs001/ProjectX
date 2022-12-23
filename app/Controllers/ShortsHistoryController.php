<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProfileService;
use App\Template;
use App\Services\ShortsService;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class ShortsHistoryController
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;
    private ProfileService $profileService;
    private ShortsService $shortsService;

    public function __construct(
        ShowCryptoCurrencyService $showCryptoCurrencyService,
        ProfileService $profileService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
        $this->profileService = $profileService;
    }

    public function showForm(): Template
    {
        $allTransactions = new ShortsService( $this->showCryptoCurrencyService);
        $history=$allTransactions->showHistory();
        return new Template("short/shortsHistory.twig",
            [
                "items"=>$this->profileService->sumInWallet(),
                "userData"=>$history->all()
            ]
        );
    }
}