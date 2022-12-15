<?php declare(strict_types=1);

namespace App\Models;

class BuySellServiceRequest
{
    public float $amount;
    public string $symbol;

    public function __construct(float $amount,
                                string $symbol
    )
    {
        $this->amount = $amount;
        $this->symbol = $symbol;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}