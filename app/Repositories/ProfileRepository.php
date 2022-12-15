<?php declare(strict_types=1);

namespace App\Repositories;


use App\Redirect;
use App\Session;
use Carbon\Carbon;

class ProfileRepository
{
    public function showTotalInMoneyBag(): float
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select date,money_bag from users_crypto_profiles where user_id = ?', [$_SESSION["id"]]);

            $userDBmoney=$resultSet->fetchAllAssociative();
        $totalMoneyInAccount = 0;

        foreach ($userDBmoney as $item) {
            $totalMoneyInAccount += (float)$item["money_bag"];
        }
        return $totalMoneyInAccount;
    }

    public function moneyTransfer($moneyToBag): Redirect
    {
        if($moneyToBag <=0) {

            Session::put("message", "You can't put negative amount of money into your wallet");
            return new Redirect("/profile");
        }else{
            DatabaseRepository::getConnection()->executeQuery(
                'INSERT INTO users_crypto_profiles SET
                                      money_bag = ?,
                                      user_id = ?,
                                      date = ?',
                ["+".$moneyToBag, Session::getData("id"), Carbon::now()]
            );
            Session::put("message", "You have successfully put money into your wallet");
        }
        return new Redirect("/profile");
    }
}

