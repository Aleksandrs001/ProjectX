<?php

namespace App\Services;

use App\Repositories\ShortsRepository;
use App\Models\Collections\CryptoCurrenciesCollection;

class ShortsService
{

    public function showAccInfo(): CryptoCurrenciesCollection
    {
        $start= new ShortsRepository();
        return $start->showAccInfo();
    }

     public function showHistory(): CryptoCurrenciesCollection
     {
        $start= new ShortsRepository();
        return $start->showHistory();
    }
}
