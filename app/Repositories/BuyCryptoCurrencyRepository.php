<?php declare(strict_types=1);

namespace App\Repositories;

use App\Redirect;
use App\Session;

class BuyCryptoCurrencyRepository
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
}