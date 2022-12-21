<?php declare(strict_types=1);

namespace App\Repositories;

use App\Session;
use App\Redirect;

class BuySellCryptoCurrencyRepository
{

    public function buyCryptoCurrency($price,$symbol,$amount): Redirect
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select money_bag  from users_crypto_profiles where user_id = ?', [Session::getData("id")]);
        $userWallet = $resultSet->fetchAllAssociative();
        $totalMoney = 0;
        foreach ($userWallet as $moneyCount) {
            $totalMoney += (int)$moneyCount["money_bag"];
        }
            if ($price * $amount <= $totalMoney) {
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET user_id = ?,
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      coin_price=?,
                                      date= ?,
                                      money_bag = ?',
                    [
                        Session::getData("id"),
                        $symbol,
                        "+" . $amount,
                        $price,
                        date("Y-m-d H:i:s"),
                        "-" . $price * $amount
                    ]
                );

                Session::put("message", "You have successfully bought " . $amount . " " . $symbol);
                return new Redirect("/crypto{$symbol}");
            } else {
                Session::put("message", "You don't have enough money to buy this amount of coins. Total in wallet: $totalMoney$");
            }
            return new Redirect("/crypto{$symbol}");
    }
    public function sellCryptoCurrency(float $price,string $symbol, float $amount): Redirect
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'SELECT coin_amount FROM users_crypto_profiles WHERE user_id = ? AND coin_symbol = ?',
            [
                Session::getData("id"),
                $symbol
            ]
        );
        $user = $resultSet->fetchAllAssociative();
        $coinAmountInDB = 0;

        foreach ($user as $coinsInDB) {
            $coinAmountInDB += (int)$coinsInDB["coin_amount"];
        }
        if ($amount <= $coinAmountInDB) {
            DatabaseRepository::getConnection()->executeQuery(
                'INSERT INTO users_crypto_profiles SET user_id = ?,
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      coin_price=?,
                                      date = ?,
                                      money_bag = ?',
                [
                    Session::getData("id"),
                    $symbol,
                    "-" . $amount,
                    $price,
                    date("Y-m-d H:i:s"),
                    "+" . $price * $amount
                ]
            );

            Session::put("message", "You have successfully sold " . $amount . " " . $symbol);
        } else {
            Session::put("message", "You don't have enough coins to sell this amount. Total in wallet: $coinAmountInDB coins of $symbol.");
        }
        return new Redirect("/crypto{$symbol}");
    }
}