<?php

namespace App\Repositories;

use App\Session;
use App\Redirect;
use Carbon\Carbon;
use App\Models\PipeRequest;

class CoinsTransferRepository
{
    public function showSymbolNameAndAmount(): array
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount from users_crypto_profiles where user_id = ?', [Session::getData("id")]);
        $users = $resultSet->fetchAllAssociative();
        $userCoinsSymbolsInDB = [];
        $userSymbols=[];
        foreach ($users as $symbols) {
                $userCoinsSymbolsInDB[$symbols["coin_symbol"]][]= $symbols["coin_amount"];
        }
        foreach ($userCoinsSymbolsInDB as $key => $value) {
            if(array_sum($value)>0)$userSymbols[]=new PipeRequest( $key, array_sum($value));
        }
        return $userSymbols;
    }
    public function startOperation($postDatas): Redirect
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount from users_crypto_profiles where user_id = ?', [Session::getData("id")]);
        $users = $resultSet->fetchAllAssociative();

            DatabaseRepository::getConnection()->executeQuery(
                'INSERT INTO users_crypto_profiles SET
                                      coin_symbol = ?,
                                      coin_amount = ?,
                                      description = ?,
                                      money_bag = ?,
                                      user_id = ?,
                                      date = ?',
                [
                    $postDatas->currency,
                    "-{$postDatas->amount}",
                    "transfer to user id:". $postDatas->recipient,
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
                $postDatas->currency,
                "+{$postDatas->amount}",
                "transfer From user id:". Session::getData("id"),
                0,
                $postDatas->recipient, Carbon::now()
            ]
        );
        Session::put("message","you have successfully transferred {$postDatas->amount} {$postDatas->currency} to user id: {$postDatas->recipient}");
        return new Redirect("/coinTransfer");
    }
}