<?php declare(strict_types=1);

namespace App\Models\Collections;

use App\Models\CoinMarket;

class CoinMarketCollection
{

    private array $coinMarketData = [];

    public function __construct(array $coinMarketData = [])
    {

        foreach ($coinMarketData as $coinMarket) {
            $this->add($coinMarket);
        }
    }

    public function add(CoinMarket $coinMarket): void
    {
        $this->coinMarketData [] = $coinMarket;
    }

    public function get(): array
    {
        return $this->coinMarketData;
    }
}
