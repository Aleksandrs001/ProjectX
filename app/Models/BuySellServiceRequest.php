<?php

namespace App\Models;

class BuySellServiceRequest
{
    public string $amount;
    public string $symbol;
    public string $price;

    public function __construct(string $amount,
                                string $symbol,
                                string $price)
    {
        $this->amount = $amount;
        $this->symbol = $symbol;
        $this->price = $price;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}