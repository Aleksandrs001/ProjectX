<?php

namespace App\Models;

class CoinTransferServiceRequest
{
    public string $login;
    public string $email;
    public string $password;
    public int $recipient;
    public float $amount;
    public string $currency;

    public function __construct(string $login, string $email, string $password, int $recipient, float $amount, string $currency)
    {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->recipient = $recipient;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getRecipient(): int
    {
        return $this->recipient;
    }
}