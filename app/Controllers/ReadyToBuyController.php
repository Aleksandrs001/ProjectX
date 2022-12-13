<?php

namespace App\Controllers;

use App\Models\Collections\CryptoCurrenciesCollection;
use App\Redirect;
use App\Repositories\DatabaseRepository;
use App\Services\CryptoCurrency\ListCryptoCurrenciesService;
use App\Session;
use App\Template;

class ReadyToBuyController
{
    public CryptoCurrenciesCollection $cryptoCurrencies;

    public function showForm(): Template
    {
        $service = new ListCryptoCurrenciesService();
        $this->cryptoCurrencies = $cryptoCurrencies = $service->execute(
            explode(",", $symbol ?? "DOGE"
            )
        );
        return new Template("readyToBuy/readyToBuy.twig", [
            'response' => $cryptoCurrencies->all()
        ]);
    }

    public function buySell()
    {
        if ($_POST["buyAmount"] == "") {
            unset($_POST["buyAmount"]);
        }
        if ($_POST["sellAmount"] == "") {
            unset($_POST["sellAmount"]);
        }

        $symbol = $_POST["symbol"];
        $price = $_POST["price"];

        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select money_bag  from users_crypto_profiles where user_id = ?', [$_SESSION["id"]]);
        $userWallet = $resultSet->fetchAllAssociative();
        $totalMoney = 0;
        foreach ($userWallet as $moneyCount) {
            $totalMoney += (int)$moneyCount["money_bag"];
        }
        if (isset($_POST["buyAmount"])) {
            if ($price * $_POST["buyAmount"] <= $totalMoney) {
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET user_id = ?, coin_symbol = ?, coin_amount = ?, coin_price=?, buy_date= ?, money_bag = ?', [$_SESSION["id"], $symbol, "+" . $_POST["buyAmount"], $price, date("Y-m-d H:i:s"), "-" . $price * $_POST["buyAmount"]]);
                unset($_SESSION["crypta"]);
                Session::put("message", "You have successfully bought " . $_POST["buyAmount"] . " " . $symbol);
            } else {
                Session::put("message", "You don't have enough money to buy this amount of coins. Total in wallet: $totalMoney$");
            }
            return new Redirect("/readyToBuy");
        }

        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'SELECT  coin_amount FROM users_crypto_profiles WHERE user_id = ? AND coin_symbol = ?', [$_SESSION["id"], $symbol]);
        $user = $resultSet->fetchAllAssociative();

        $items = 0;

        foreach ($user as $item) {
            $items += (int)$item["coin_amount"];
        }
        if (isset($_POST["sellAmount"])) {
            if ($_POST["sellAmount"] <= $items) {
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET user_id = ?, coin_symbol = ?, coin_amount = ?, coin_price=?, sell_date= ?, money_bag = ?', [$_SESSION["id"], $symbol, "-" . $_POST["sellAmount"], $price, date("Y-m-d H:i:s"), "+" . $price * $_POST["sellAmount"]]);
                unset($_SESSION["crypta"]);
                Session::put("message", "You have successfully sold " . $_POST["sellAmount"] . " " . $symbol);
            } else {
                Session::put("message", "You don't have enough coins to sell this amount. Total in wallet: $items coins of $symbol.");
            }
            return new Redirect("/readyToBuy");
        }
        return new Redirect("/readyToBuy");
    }

}