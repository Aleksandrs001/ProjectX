<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\CoinTransferServiceRequest;
use App\Session;
use App\Redirect;
use Carbon\Carbon;
use App\Models\PipeRequest;
use App\Models\Collections\CryptoCurrenciesCollection;

class CoinsTransferRepository
{

    public function showSymbolNameAndAmount(): CryptoCurrenciesCollection
    {
        $collection = new CryptoCurrenciesCollection();
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount from users_crypto_profiles where user_id = ?',
            [
                Session::getData("id")
            ]
        );
        $users = $resultSet->fetchAllAssociative();

        $userCoinsSymbolsInDB = [];
        foreach ($users as $symbols) {
                $userCoinsSymbolsInDB[$symbols["coin_symbol"]][]= $symbols["coin_amount"];
        }
        foreach ($userCoinsSymbolsInDB as $key => $value) {
            if( array_sum($value) > 0 )$collection->add( new PipeRequest( $key, array_sum($value)));
        }
        return $collection;
    }

    public function startOperation(CoinTransferServiceRequest $postUserForm): Redirect
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount from users_crypto_profiles where user_id= ? and coin_symbol=? ',
            [
                Session::getData("id"),
                $postUserForm->getCurrency(),
            ]
        );
        $checkForMaxCoinAmount = $resultSet->fetchAllAssociative();
        $userCoinsSymbolsInDB = [];
        $DB_userCoinsAmount="";

        foreach ($checkForMaxCoinAmount as $symbols) {
            $userCoinsSymbolsInDB[$symbols["coin_symbol"]][]= $symbols["coin_amount"];
        }
        foreach ($userCoinsSymbolsInDB as $value) {
            $DB_userCoinsAmount= array_sum($value);
        }

        if($DB_userCoinsAmount>=$postUserForm->amount) {
            $resultSet = DatabaseRepository::getConnection()->executeQuery(

                'select login, email, password from users where id = ?',
                [
                    Session::getData("id")
                ]
            );
            $users = $resultSet->fetchAllAssociative();
            $userInfo=[];
            foreach ($users as $user){
                $userInfo=$user;
            }
            if ($userInfo["login"] == $postUserForm->getLogin() &&
                $userInfo["email"] == $postUserForm->getEmail() &&
                $userInfo["password"] == $postUserForm->getPassword()
            ) {
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      description = ?,
                                      money_bag = ?,
                                      user_id = ?,
                                      date = ?,
                                      transaction=?',
                    [
                        $postUserForm->getCurrency(),
                        "-{$postUserForm->getAmount()}",
                        "transferred to user id:" . $postUserForm->getRecipient(),
                        0,
                        Session::getData("id"),
                        Carbon::now(),
                        "transfer"

                    ]
                );
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      description = ?,
                                      money_bag = ?,
                                      user_id = ?,
                                      date = ?',
                    [
                        $postUserForm->getCurrency(),
                        "+{$postUserForm->getAmount()}",
                        "transfer From user id:" . Session::getData("id"),
                        0,
                        $postUserForm->recipient, Carbon::now()
                    ]
                );
                Session::put("message", "you have successfully transferred {$postUserForm->getAmount()}
         {$postUserForm->getCurrency()} to user id: {$postUserForm->getRecipient()}");
            } else {
                Session::put("message", "wrong login, email or password");
            }
        }else{
            Session::put("message", "you don't have enough {$postUserForm->getCurrency()} to transfer");
        }
        return new Redirect("/coinTransfer");
    }
}