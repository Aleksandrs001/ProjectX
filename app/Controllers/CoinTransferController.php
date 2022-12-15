<?php

namespace App\Controllers;

use App\Template;
use App\Services\CoinTransferService;
use App\Models\CoinTransferServiceRequest;

class CoinTransferController
{
    public function transfer(): Template
    {

        return new Template("coinTransfer/transfer.twig");
    }

    public function transferMoney()
    {
//        var_dump($_POST["login"],$_POST["email"], $_POST["password"]);die;
        $postDatas= new CoinTransferServiceRequest(
        $login = $_POST["login"],
        $email = $_POST["email"],
        $password = md5($_POST["password"])
    );


        $start= new CoinTransferService($postDatas);
//        $start->Transfer($postDatas);


        return ;
    }
}
