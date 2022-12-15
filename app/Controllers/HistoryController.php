<?php

namespace App\Controllers;

use App\Template;
use App\Services\HistoryService;

class HistoryController
{
    public function showForm(): Template
    {
        $allTransactions = new HistoryService();
        $history=$allTransactions->showHistory();

        return new Template("history/history.twig",
            [
                "userData"=>$history,
            ]
        );
    }
}