<?php declare(strict_types=1);

namespace App\Services\CryptoCurrency;

use App\Repositories\CryptoCurrenciesRepository;
use App\Models\Collections\CryptoCurrenciesCollection;

class ListCryptoCurrenciesService
{
    public CryptoCurrenciesRepository $cryptoCurrenciesRepository;

    public function __construct(CryptoCurrenciesRepository $cryptoCurrenciesRepository)
    {
        $this->cryptoCurrenciesRepository = $cryptoCurrenciesRepository;
    }

    public function execute(array $symbols): CryptoCurrenciesCollection
    {
        $cryptoCurrencies = $this->cryptoCurrenciesRepository->fetchAllBySymbols($symbols);

        foreach ($cryptoCurrencies as $cryptoCurrency) {
            $quote = $this->cryptoCurrenciesRepository->fetchAllBySymbols($cryptoCurrency->getSymbol());
            $cryptoCurrency->setQuote($quote);
        }
        return $cryptoCurrencies;
    }
}