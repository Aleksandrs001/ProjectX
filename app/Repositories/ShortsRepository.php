<?php declare(strict_types=1);

namespace App\Repositories;

use App\Session;
use App\Redirect;
use Carbon\Carbon;
use App\Models\PipeRequest;
use App\Models\PriceRequest;
use App\Models\Pipe2request;
use App\Models\BuySellServiceRequest;
use App\Models\ProfileServiceRequest;
use App\Models\Collections\CryptoCurrenciesCollection;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;

class ShortsRepository
{

    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
        $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }

    public function showAccInfo(): CryptoCurrenciesCollection
    {

        $resultSet = DatabaseRepository::getConnection()->executeQuery(

            'select coin_symbol_shorts, coin_amount_shorts, coin_price_shorts  from shorts where user_id_shorts = ?',
            [
                Session::getData("id")
            ]
        );
        $users = $resultSet->fetchAllAssociative();
        $collection = new CryptoCurrenciesCollection();
        $userCoinsSymbolsInDB = [];
        $userCoins = [];
        foreach ($users as $symbols) {
            $userCoinsSymbolsInDB[$symbols["coin_symbol_shorts"]][] = $symbols["coin_amount_shorts"];
            $userCoins[$symbols["coin_symbol_shorts"]][] = $symbols["coin_price_shorts"];
        }

        $userSymbols = [];
        foreach ($userCoinsSymbolsInDB as $key => $value) {

            if (array_sum($value) > 0) $collection->add(new PipeRequest( $key, array_sum($value))); //sum of coins
        }

        return $collection;
    }

    public function also()
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery('select
    description_shorts, coin_symbol_shorts,coin_amount_shorts,date_shorts,coin_price_shorts from shorts where
    user_id_shorts = ?', [Session::getData("id")]);

        $userDBmoney = $resultSet->fetchAllAssociative();
        $totalMoneyInAccount = 0;

        foreach ($userDBmoney as $item) {
            $totalMoneyInAccount += (float)$item["coin_price_shorts"];
        }
        return $totalMoneyInAccount;

    }

    public function showHistory(): CryptoCurrenciesCollection
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(
            'select * from shorts where user_id_shorts = ?', [Session::getData("id")]);
        $users = $resultSet->fetchAllAssociative();
        $collection = new CryptoCurrenciesCollection();
        foreach ($users as $user) {
            $collection->add(new ProfileServiceRequest(
                $user["coin_symbol_shorts"],
                $user["coin_amount_shorts"],
                $user["coin_price_shorts"],
                $user["date_shorts"],
                "bang",
                $user["description_shorts"]
            ));
        }
        return $collection;
    }

    public function buyShorts(BuySellServiceRequest $postUserData): Redirect
    {
        $getCoinInfo = $this->showCryptoCurrencyService->execute($postUserData->getSymbol());
        $getCoinInfo = new PriceRequest( $getCoinInfo->getPrice());

        DatabaseRepository::getConnection()->executeQuery(
            'INSERT INTO shorts SET
                                      coin_symbol_shorts = ?,
                                      coin_amount_shorts = ?,
                                      coin_price_shorts = ?,
                                      description_shorts = ?,
                                      user_id_shorts = ?,
                                      date_shorts = ?,
                                      sum_of_shorts=?',
            [
                $postUserData->getSymbol(),
                +$postUserData->getAmount(),
                $getCoinInfo->getPrice(),
                "buy",
                Session::getData("id"),
                Carbon::now(),
                "-".$getCoinInfo->getPrice()*$postUserData->getAmount()
            ]);
             DatabaseRepository::getConnection()->executeQuery('INSERT INTO users_crypto_profiles SET money_bag = ?, user_id = ?, coin_symbol = ?,date = ?,description = ?',
                 [
                     -$getCoinInfo->getPrice()*$postUserData->getAmount(),
                     Session::getData("id"),
                     $postUserData->getSymbol(),
                     Carbon::now(),
                     "Rented in shorts {$postUserData->getSymbol()}, {$postUserData->getAmount()} coin/s"
                 ]);

        Session::put("message", "Congrats! successfully rented Shorts" ." ". $postUserData->getAmount() . " " . $postUserData->getSymbol() . " " . $getCoinInfo->getPrice() . "$");
        return new Redirect("/shorts");
    }

    public function sellShorts($postUserData): Redirect
    {
        $getCoinInfo =$this->showCryptoCurrencyService->execute($postUserData->getSymbol());
        $getCoinInfo = new PriceRequest( $getCoinInfo->getPrice());
        DatabaseRepository::getConnection()->executeQuery(
            'INSERT INTO shorts SET
                                      coin_symbol_shorts = ?,
                                      coin_amount_shorts = ?,
                                      coin_price_shorts = ?,
                                      description_shorts = ?,
                                      user_id_shorts = ?,
                                      date_shorts = ?,
                                      sum_of_shorts=?',
            [
                $postUserData->getSymbol(),
                -$postUserData->getAmount(),
                $getCoinInfo->getPrice(),
                "sell",
                Session::getData("id"),
                Carbon::now(),
                "+".$getCoinInfo->getPrice()*$postUserData->getAmount()
            ]
        );
        DatabaseRepository::getConnection()->executeQuery('INSERT INTO users_crypto_profiles SET money_bag = ?, user_id = ?, coin_symbol = ?,date = ?,description = ?',
            [
                "+".$getCoinInfo->getPrice()*$postUserData->getAmount(),
                Session::getData("id"),
                $postUserData->getSymbol(),
                Carbon::now(),
                "Sold in shorts {$postUserData->getSymbol()}, {$postUserData->getAmount()} coin/s"
            ]);

        Session::put("message", "Congrats! successfully Sold rented Shorts" ." ". $postUserData->getAmount() . " " . $postUserData->getSymbol() . " " .round($getCoinInfo->getPrice(), 3)  . "$");
        return new Redirect("/shorts");
    }
}
