<?php declare(strict_types=1);

namespace App\Services;

use App\Models\CoinTransferServiceRequest;
use App\Repositories\CoinsTransferRepository;
use App\Models\Collections\CryptoCurrenciesCollection;

class CoinTransferService
{
    public function showUserAccinfo(): CryptoCurrenciesCollection
    {
        $start= new CoinsTransferRepository();
        return  $start->showSymbolNameAndAmount();
    }
    public function transfer(CoinTransferServiceRequest $postUserForm): object
    {
       $start= new CoinsTransferRepository();
       return  $start->startOperation($postUserForm);
    }
}