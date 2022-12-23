<?php declare(strict_types=1);

namespace App\Models;

class Pipe2request
{
    public float $userPriceRequest;

    public function __construct(float $userPriceRequest)
    {
        $this->userPriceRequest = $userPriceRequest;
    }

    public function getUserPriceRequest(): float
    {
        return $this->userPriceRequest;
    }
}