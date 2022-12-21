<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Collections\CryptoCurrenciesCollection;

class PipeRequest extends CryptoCurrenciesCollection
{
    public string $CoinsSymbol;
    public float $CoinsCount;


    public function __construct
    (
        string $CoinsSymbol,
        float  $CoinsCount
    )
    {
        $this->CoinsSymbol = $CoinsSymbol;
        $this->CoinsCount = $CoinsCount;

    }
    public function getCoinsSymbol(): string
    {
        return $this->CoinsSymbol;
    }
    public function getCoinsCount(): float
    {
        return $this->CoinsCount;
    }
}