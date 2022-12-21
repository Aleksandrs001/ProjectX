<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\CryptoCurrency;
use App\Models\Collections\CryptoCurrenciesCollection;

interface CryptoCurrenciesRepository
{
    public function fetchAllBySymbols(array $symbols): CryptoCurrenciesCollection;
    public function fetchBySymbol(string $symbol): CryptoCurrency;
    public function fetchQuote(string $symbol): Quote;
}