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
        $this->start = $start->showUserAccinfo();
        return new Template("coinTransfer/transfer.twig", ["start" => $this->start]);
    }

    public function transferMoney(): object
    {
        $postDatas = new CoinTransferServiceRequest(
            $login = $_POST["login"],
            $email = $_POST["email"],
            $password = md5($_POST["password"]),
            $recipient = $_POST["recipient"],
            $amount = $_POST["amount"],
            $currency = $_POST["currency"]
        );
        $start = new CoinTransferService();
        return $start->transfer($postDatas);
    }
}
