<?php declare(strict_types=1);

namespace App\Services\CryptoCurrency;

use App\Models\Collections\CryptoCurrenciesCollection;
use App\Repositories\CoinMarketCapCryptoCurrencyRepository;
use App\Repositories\CryptoCurrenciesRepository;

class ListCryptoCurrenciesService
{
    public CryptoCurrenciesRepository $cryptoCurrenciesRepository;

    public function __construct()
    {
        $this->cryptoCurrenciesRepository = new CoinMarketCapCryptoCurrencyRepository();
    }

    public function execute(array $symbols): CryptoCurrenciesCollection
    {
        $cryptoCurrencies = $this->cryptoCurrenciesRepository->fetchAllBySymbols($symbols);
        foreach ($cryptoCurrencies as $cryptoCurrency) {
//            var_dump($cryptoCurrency);die;
            $quote = $this->cryptoCurrenciesRepository->fetchAllBySymbols($cryptoCurrency->getSymbol());
            $cryptoCurrency->setQuote($quote);
        }
        return $cryptoCurrencies;
    }
}