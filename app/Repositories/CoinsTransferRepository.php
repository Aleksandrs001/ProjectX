<?php

namespace App\Repositories;



use App\Models\CoinTransferServiceRequest;
use App\Session;

class CoinsTransferRepository
{
    public CoinTransferServiceRequest $postDatas;

    public function __construct(CoinTransferServiceRequest $postDatas)
    {
        $this->postDatas=$postDatas;

        var_dump($this->postDatas);

        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select user_id, coin_symbol, coin_amount from users_crypto_profiles where user_id = ?', [Session::getData("id")]);
        $users = $resultSet->fetchAllAssociative();
        echo"<pre>";
        var_dump($users);die;
    }
}