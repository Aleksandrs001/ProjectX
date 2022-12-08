<?php declare(strict_types=1);

namespace App\Models;

class CoinMarket
{
    private string $id;
    private string $name;
    private string $symbol;
    private string $price;
    private string $price_change_24;

    public function __construct(string $id,
                                string $name,
                                string $symbol,
                                string $price,
                                string $price_change_24
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->price_change_24 = $price_change_24;
    }

    public function getId(): string
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

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getPriceChange24(): string
    {
        return $this->price_change_24;
    }
}