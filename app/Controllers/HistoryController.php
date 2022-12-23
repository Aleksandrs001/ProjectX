<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Collections\CryptoCurrenciesCollection;
use App\Services\ProfileService;
use App\Template;
use App\Services\HistoryService;

class HistoryController
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function showForm(): Template
    {

        $allTransactions = new HistoryService();
        $history=$allTransactions->showHistory();

        return new Template("history/history.twig",
            [
                "items"=>$this->profileService->sumInWallet(),
                "userData"=>$history->all(),
            ]
        );
    }
    public function showSymbolAmountAndPrice(): CryptoCurrenciesCollection
    {
        $allTransactions = new HistoryService();
        return $allTransactions->showSymbolAmountAndPrice();
    }
}