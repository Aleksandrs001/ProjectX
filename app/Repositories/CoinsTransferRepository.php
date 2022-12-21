<?php declare(strict_types=1);

namespace App\Repositories;

use App\Session;
use App\Redirect;
use Carbon\Carbon;
use App\Models\PipeRequest;
use App\Models\CoinTransferServiceRequest;
use App\Models\Collections\CryptoCurrenciesCollection;

class CoinsTransferRepository
{
    public array $userSymbols=[];

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
        $userSymbols=[];
        foreach ($users as $symbols) {
                $userCoinsSymbolsInDB[$symbols["coin_symbol"]][]= $symbols["coin_amount"];
        }
        foreach ($userCoinsSymbolsInDB as $key => $value) {
            if( array_sum($value) > 0 )$collection->add( new PipeRequest( $key, array_sum($value)));
        }
        return $collection;
    }


    public function startOperation(CoinTransferServiceRequest $postDatas): Redirect
    {

        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount from users_crypto_profiles where user_id= ? and coin_symbol=? ',
            [
                Session::getData("id"),
                $postDatas->getCurrency(),
            ]
        );
        $checkForMaxCoinAmount = $resultSet->fetchAllAssociative();

        $userCoinsSymbolsInDB = [];
        $DB_userCoinAmount="";

        foreach ($checkForMaxCoinAmount as $symbols) {
            $userCoinsSymbolsInDB[$symbols["coin_symbol"]][]= $symbols["coin_amount"];
        }
        foreach ($userCoinsSymbolsInDB as $value) {
            $DB_userCoinAmount= array_sum($value);
        }

        if($DB_userCoinAmount>=$postDatas->amount) {
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
            if ($userInfo["login"] == $postDatas->getLogin() &&
                $userInfo["email"] == $postDatas->getEmail() &&
                $userInfo["password"] == $postDatas->getPassword()
            ) {
                DatabaseRepository::getConnection()->executeQuery(
                    'INSERT INTO users_crypto_profiles SET
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      description = ?,
                                      money_bag = ?,
                                      user_id = ?,
                                      date = ?',
                    [
                        $postDatas->getCurrency(),
                        "-{$postDatas->getAmount()}",
                        "transfer to user id:" . $postDatas->getRecipient(),
                        0,
                        Session::getData("id"),
                        Carbon::now()
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
                        $postDatas->getCurrency(),
                        "+{$postDatas->getAmount()}",
                        "transfer From user id:" . Session::getData("id"),
                        0,
                        $postDatas->recipient, Carbon::now()
                    ]
                );
                Session::put("message", "you have successfully transferred {$postDatas->getAmount()}
         {$postDatas->getCurrency()} to user id: {$postDatas->getRecipient()}");
            } else {
                Session::put("message", "wrong login, email or password");
            }
        }else{
            Session::put("message", "you don't have enough {$postDatas->getCurrency()} to transfer");
        }
        return new Redirect("/coinTransfer");
    }
}