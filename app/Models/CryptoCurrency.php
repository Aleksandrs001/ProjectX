<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Collections\CryptoCurrenciesCollection;

class CryptoCurrency extends CryptoCurrenciesCollection
{
    public string $symbol;
    public string $name;
    public float $price;
    public float $percentChange1h;
    public float $percentChange24h;
    public float $percentChange7d;

    public function __construct(string $symbol, string $name, float $price, float $percentChange1h, float $percentChange24h, float $percentChange7d)
    {
        $this->symbol = $symbol;
        $this->name = $name;
        $this->price = $price;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
        $this->percentChange7d = $percentChange7d;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPercentChange1h(): float
    {
        return $this->percentChange1h;
    }

    public function getPercentChange7d(): float
    {
        return $this->percentChange7d;
    }

    public function getPercentChange24h(): float
    {
        return $this->percentChange24h;
    }
}