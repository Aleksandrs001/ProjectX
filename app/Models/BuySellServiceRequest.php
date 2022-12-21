<?php declare(strict_types=1);

namespace App\Models;

class BuySellServiceRequest
{
    public float $amount;
    public string $symbol;

    public function __construct(
                                string $symbol,
                                float $amount
    )
    {
        $this->amount = $amount;
        $this->symbol = $symbol;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}