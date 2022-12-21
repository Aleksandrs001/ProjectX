<?php

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

        ShowCryptoCurrencyService $showCryptoCurrencyService
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

    public function getAveragePrice()
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery(

            'select coin_symbol_shorts, coin_amount_shorts, coin_price_shorts  from shorts where user_id_shorts = ?',
            [
                Session::getData("id")
            ]
        );
        $users = $resultSet->fetchAllAssociative();

        $userPrice = [];
        foreach ($users as $symbols) {

            $userPrice[$symbols["coin_symbol_shorts"]][] = $symbols["coin_price_shorts"];
        }

        $userPriceRequest = [];
        foreach ($userPrice as $key => $value) {
            if (array_sum($value) < 0) $userPriceRequest[$key] = array_sum($value) / count($value);//average buy price
        }
        $cc = new Pipe2Request($userPriceRequest);

        return $cc->getUserPriceRequest();
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
    public function buyShorts(BuySellServiceRequest $fromPost): Redirect
    {

        $getCoinInfo = $this->showCryptoCurrencyService->execute($fromPost->getSymbol());
        $getCoinInfo = new PriceRequest( $getCoinInfo->getPrice());

        DatabaseRepository::getConnection()->executeQuery(
            'INSERT INTO shorts SET
                                      coin_symbol_shorts = ?,
                                      coin_amount_shorts = ?,
                                      coin_price_shorts = ?,
                                      description_shorts = ?,
                                      user_id_shorts = ?,
                                      date_shorts = ?',
            [
                $fromPost->getSymbol(),
                (float)"+" . $fromPost->getAmount(),
                "-" . $getCoinInfo->getPrice(),
                "buy",
                Session::getData("id"),
                Carbon::now()
            ]
        );
        Session::put("message", "Congrats! successfully rented" ." ". $fromPost->getAmount() . " " . $fromPost->getSymbol() . " " . $getCoinInfo->getPrice() . "$");
        return new Redirect("/short");
    }

    public function sellShorts($fromPost): Redirect
    {


        $getCoinInfo =$this->showCryptoCurrencyService->execute($fromPost->getSymbol());
        $getCoinInfo = new PriceRequest( $getCoinInfo->getPrice());
        DatabaseRepository::getConnection()->executeQuery(
            'INSERT INTO shorts SET
                                      coin_symbol_shorts = ?,
                                      coin_amount_shorts = ?,
                                      coin_price_shorts = ?,
                                      description_shorts = ?,
                                      user_id_shorts = ?,
                                      date_shorts = ?',
            [
                $fromPost->getSymbol(),
                -$fromPost->getAmount(),
                +$getCoinInfo->getPrice(),
                "sell",
                Session::getData("id"),
                Carbon::now()
            ]
        );

        Session::put("message", "Congrats! successfully Sold rented" ." ". $fromPost->getAmount() . " " . $fromPost->getSymbol() . " " . $getCoinInfo->getPrice() . "$");
        return new Redirect("/short");
    }
}
