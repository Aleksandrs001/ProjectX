<?php declare(strict_types=1);

namespace App\Models;

class CoinMarket
{
    private int $id;
    private string $name;
    private string $symbol;
    private float $price;
    private float $price_change_24;

    public function __construct(int $id,
                                string $name,
                                string $symbol,
                                float $price,
                                float $price_change_24
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->price_change_24 = $price_change_24;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPriceChange24(): float
    {
        return $this->price_change_24;
    }
}
