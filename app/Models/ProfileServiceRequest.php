<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Collections\CryptoCurrenciesCollection;

class ProfileServiceRequest extends CryptoCurrenciesCollection
{
    private ?string $coinSymbol;
    private ?string $coinAmount;
    private ?string $coinPrice;
    private ?string $buyDate;
    private ?string $sellDate;
    private ?string $moneyBag;

    public function __construct(
                                ?string $coinSymbol=null,
                                ?string $coinAmount=null,
                                ?string $coinPrice=null,
                                ?string $buyDate=null,
                                ?string $sellDate=null,
                                ?string $moneyBag=null
    )
    {
        $this->coinSymbol = $coinSymbol;
        $this->coinPrice = $coinPrice;
        $this->buyDate = $buyDate;
        $this->sellDate = $sellDate;
        $this->moneyBag = $moneyBag;
        $this->coinAmount = $coinAmount;
    }

    public function getBuyDate(): ?string
    {
        return $this->buyDate;
    }

    public function getCoinPrice(): ?string
    {
        return $this->coinPrice;
    }

    public function getCoinSymbol(): ?string
    {
        return $this->coinSymbol;
    }

    public function getCoinAmount(): ?string
    {
        return $this->coinAmount;
    }

    public function getMoneyBag(): ?string
    {
        return $this->moneyBag;
    }

    public function getSellDate(): ?string
    {
        return $this->sellDate;
    }

}