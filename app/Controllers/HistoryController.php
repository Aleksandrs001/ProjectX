<?php

namespace App\Controllers;


use App\Services\HistoryService;
use App\Template;

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