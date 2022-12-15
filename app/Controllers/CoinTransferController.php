<?php

namespace App\Controllers;


use App\Template;

class CoinTransferController
{
    public function transfer(): Template
    {
//        $transfer = new Post((float) $_POST["transfer"]);
//        $start = new CoinTransferService();

        return new Template("coinTransfer/transfer.twig");
    }
}
