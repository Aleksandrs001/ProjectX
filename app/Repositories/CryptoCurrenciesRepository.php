<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Collections\CryptoCurrenciesCollection;

interface CryptoCurrenciesRepository
{
    public function fetchAllBySymbols(array $symbols): CryptoCurrenciesCollection;
}