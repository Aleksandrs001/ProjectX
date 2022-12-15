<?php

namespace App\Repositories;

use App\Redirect;
use App\Session;

class SellCryptoCurrencyRepository
{
    public function sellCryptoCurrency(string $price,string $symbol, string $amount): Redirect
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'SELECT  coin_amount FROM users_crypto_profiles WHERE user_id = ? AND coin_symbol = ?', [Session::getData("id"), $symbol]);
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