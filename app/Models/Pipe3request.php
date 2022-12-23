<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Collections\CryptoCurrenciesCollection;

class Pipe3request extends CryptoCurrenciesCollection
{

    public string $symbol;
    public float $summ;
    public float $amount;

    public function __construct(string $symbol,float $summ,float $amount)
    {
        $this->symbol = $symbol;
        $this->summ = $summ;
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
    public function getSumm(): float
    {
        return $this->summ;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}