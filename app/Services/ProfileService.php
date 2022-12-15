<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\ProfileRepository;

class ProfileService
{
    public function startMoneyCheckTransfer(float $putIntoDB): Redirect
    {
        $start= new ProfileRepository();
      return $start->moneyTransfer($putIntoDB);
    }

    public function sumInWallet():float
    {
        $start= new ProfileRepository();
        $start->showTotalInMoneyBag();
        return $start->showTotalInMoneyBag();
    }
}
