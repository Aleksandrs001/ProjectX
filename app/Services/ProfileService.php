<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\DatabaseRepository;
use App\Session;
use Carbon\Carbon;


class ProfileService
{
    public function moneyTransfer(): Redirect
    {
        $date=( Carbon::now());

     $putIntoDB =$_POST["toMoneyBag"];
     if($putIntoDB <=0) {

         $_SESSION["message"]= "You can't put negative amount of money into your wallet";
         return new Redirect("/profile");
     }else{
         DatabaseRepository::getConnection()->executeQuery(
             'INSERT INTO users_crypto_profiles SET
                                      money_bag = ?,
                                      user_id = ?,
                                      buy_date= ?',
             ["+".$putIntoDB, $_SESSION["id"], $date]
         );
         Session::put("message", "You have successfully put money into your wallet");
     }
        return new Redirect("/profile");
    }
}
