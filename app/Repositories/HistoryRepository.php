<?php declare(strict_types=1);

namespace App\Repositories;

use App\Session;
use App\Models\Pipe3request;
use App\Models\ProfileServiceRequest;
use App\Models\Collections\CryptoCurrenciesCollection;

class HistoryRepository
{
    public function showAllTransactions(): CryptoCurrenciesCollection
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select * from users_crypto_profiles where user_id = ?', [Session::getData("id")]);
        $users = $resultSet->fetchAllAssociative();
        $collection = new CryptoCurrenciesCollection();

        foreach ($users as $user) {
            $collection->add(new ProfileServiceRequest(
                $user["coin_symbol"],
                $user["coin_amount"],
                $user["coin_price"],
                $user["date"],
                $user["money_bag"],
                $user["description"]
            ));
        }
        return $collection;
    }

    public function showSymbolAmountAndPrice(): CryptoCurrenciesCollection
    {
        $showSymbolAmountAndPrice = new CryptoCurrenciesCollection();
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select coin_symbol, coin_amount,transaction from users_crypto_profiles where user_id = ?',
            [
                Session::getData("id")
            ]
        );
        $users = $resultSet->fetchAllAssociative();

        $symbol = [];
        $userAmount = [];
        $userTransaction = [];

        foreach ($users as $user) {
            $symbol[$user["coin_symbol"]] = $user["coin_symbol"];
            $userAmount[$user["coin_symbol"]][] = $user["coin_amount"];
            $userTransaction[$user["coin_symbol"]][] = $user["transaction"];
        }
        foreach ($symbol as $key => $value) {
            if ($key == !null ) $showSymbolAmountAndPrice->add(new Pipe3Request($key, abs(array_sum($userTransaction[$key])), array_sum($userAmount[$key])));
        }
        return $showSymbolAmountAndPrice;
    }
}