<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Collections\CryptoCurrenciesCollection;

class ProfileServiceRequest extends CryptoCurrenciesCollection
{
    public ?string $coinSymbol;
    public ?string $coinAmount;
    public ?string $coinPrice;
    public ?string $date;
    public ?string $moneyBag;
    private ?string $description;

    public function __construct(
                                ?string $coinSymbol=null,
                                ?string $coinAmount=null,
                                ?string $coinPrice=null,
                                ?string $date=null,
                                ?string $moneyBag=null,
        ?string $description=null


    )
    {
        $this->coinSymbol = $coinSymbol;
        $this->coinAmount = $coinAmount;
        $this->coinPrice = $coinPrice;
        $this->date = $date;
        $this->moneyBag = $moneyBag;
        $this->description = $description;
    }

    public function getCoinSymbol(): ?string
    {
        return $this->coinSymbol;
    }

    public function getCoinPrice(): ?string
    {
        return $this->coinPrice;
    }

    public function getCoinAmount(): ?string
    {
        return $this->coinAmount;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getMoneyBag(): ?string
    {
        return $this->moneyBag;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}