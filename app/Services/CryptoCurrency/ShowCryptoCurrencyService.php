<?php declare(strict_types=1);

namespace App\Services\CryptoCurrency;

use App\Models\CryptoCurrency;
use App\Repositories\CryptoCurrenciesRepository;

class ShowCryptoCurrencyService
{
    private CryptoCurrenciesRepository $cryptoCurrenciesRepository;

    public function __construct(CryptoCurrenciesRepository $cryptoCurrenciesRepository)
    {
        $this->cryptoCurrenciesRepository = $cryptoCurrenciesRepository;
    }

    public function execute(string $symbol): CryptoCurrency
    {
        return $this->cryptoCurrenciesRepository->fetchBySymbol($symbol);
    }
}