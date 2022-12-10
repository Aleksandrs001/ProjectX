<?php

namespace App\Models\Collections;

class CryptoCurrenciesCollection
{

    private array $coinMarketData = [];

    public function __construct(array $coinMarketData = [])
    {

        foreach ($coinMarketData as $coinMarket) {
            $this->add($coinMarket);
        }
    }

    public function add(CryptoCurrenciesCollection $coinMarket): void
    {
        $this->coinMarketData [] = $coinMarket;
    }

    public function all(): array
    {
        return $this->coinMarketData;
    }
}
