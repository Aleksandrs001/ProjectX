<?php

namespace App\Controllers;

use App\Template;
use App\Services\ShortsService;

class ShortsHistoryController
{

    public function showForm(): Template
    {
        $allTransactions = new ShortsService();
        $history=$allTransactions->showHistory();
        return new Template("short/shortsHistory.twig",
            [
                "userData"=>$history->all()
            ]
        );
    }

}