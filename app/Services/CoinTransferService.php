<?php

namespace App\Services;

use App\Repositories\CoinsTransferRepository;
use App\Models\Collections\CryptoCurrenciesCollection;

class CoinTransferService
{
    public function showUserAccinfo(): CryptoCurrenciesCollection
    {
        $start= new CoinsTransferRepository();
        return  $start->showSymbolNameAndAmount();
    }
    public function transfer($postDatas): object
    {
       $start= new CoinsTransferRepository();
       return  $start->startOperation($postDatas);
    }
}