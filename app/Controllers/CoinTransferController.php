<?php

namespace App\Controllers;

use App\Template;
use App\Services\CoinTransferService;
use App\Models\CoinTransferServiceRequest;

class CoinTransferController
{
    public array $start;

    public function transfer(): Template
    {
        $start = new CoinTransferService();
        $this->start = $start->showUserAccinfo()->all();
        return new Template("coinTransfer/transfer.twig", ["start" => $this->start]);
    }

    public function transferMoney(): object
    {
        $postDatas = new CoinTransferServiceRequest(
            $login =(string) $_POST["login"],
            $email =(string) $_POST["email"],
            $password =md5((string) $_POST["password"]),
            $recipient =(int) $_POST["recipient"],
            $amount =(float) $_POST["amount"],
            $currency =(string) $_POST["currency"]
        );
        $start = new CoinTransferService();
        return $start->transfer($postDatas);
    }
}
