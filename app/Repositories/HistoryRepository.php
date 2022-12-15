<?php

namespace App\Repositories;

use App\Models\Collections\CryptoCurrenciesCollection;
use App\Models\ProfileServiceRequest;

class HistoryRepository
{
    public function showAllTransactions(): CryptoCurrenciesCollection
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select * from users_crypto_profiles where user_id = ?', [$_SESSION["id"]]);
        $users = $resultSet->fetchAllAssociative();
        $collection = new CryptoCurrenciesCollection();

        foreach ($users as $user) {
            $collection->add(new ProfileServiceRequest(
                $user["coin_symbol"],
                $user["coin_amount"],
                $user["coin_price"],
                $user["date"],
                $user["money_bag"]
            ));
        }
        return $collection;
    }
}