<?php

namespace App\Controllers;

use App\Services\ProfileService;
use App\Template;
use App\Services\HistoryService;

class HistoryController
{
    public function showForm(): Template
    {
        $totalMoneyInAccount = new profileService();
        $totalMoneyInAccount = $totalMoneyInAccount->sumInWallet();
        $allTransactions = new HistoryService();
        $history=$allTransactions->showHistory();

        return new Template("history/history.twig",
            [
                "items"=>$totalMoneyInAccount,
                "userData"=>$history->all()
            ]
        );
    }
}