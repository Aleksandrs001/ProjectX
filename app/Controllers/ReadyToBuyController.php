<?php

namespace App\Controllers;

use App\Repositories\DatabaseRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Template;

class ReadyToBuyController
{
    public function showForm(): Template
    {
var_dump($_POST);
        $service = new ListCryptoCurrenciesService();
        $cryptoCurrencies = $service->execute(
            explode(",", $_GET["symbols"] ?? "DOGE"
            )
        );
        return new Template("readyToBuy/readyToBuy.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }

    public function buySell()
    {
        echo "<pre>";
        var_dump("buy", $_POST["buy"] ?? 0);
        var_dump("sell", $_POST["sell"] ?? 0);


        if (isset($_POST["buy"])) {
            DatabaseRepository::getConnection()->executeQuery(
                'INSERT INTO users_crypto_profiles SET user_id = ?, coin_symbol = ?, coin_amount = ?, coin_price=?, buy_date= ?', [$_SESSION["id"]]);
        }
        if (isset($_POST["sell"])) {
            DatabaseRepository::getConnection()->executeQuery(
                'INSERT INTO users_crypto_profiles SET user_id = ?, coin_symbol = ?, coin_amount = ?, coin_price= -?, sell_date= ?', [$_SESSION["id"]] );
        }

    }


}