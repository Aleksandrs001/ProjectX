<?php  declare(strict_types=1);

namespace App\Models;

class PriceRequest
{
    public float $price;

    public function __construct(float $price)
{

    $this->price = $price;
}

    public function getPrice(): float
    {
        return $this->price;
    }
}