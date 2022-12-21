<?php

namespace App\Models;

class Pipe2request
{
    public $userPriceRequest;

    public function __construct($userPriceRequest)
    {
        $this->userPriceRequest = $userPriceRequest;
    }

    public function getUserPriceRequest()
    {
        return $this->userPriceRequest;
    }
}