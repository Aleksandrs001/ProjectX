<?php

namespace App\Services;

use App\Repositories\CoinsTransferRepository;

class CoinTransferService
{
    public function showUserAccinfo(): array
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