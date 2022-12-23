<?php declare(strict_types=1);

namespace App\Services;

use App\Models\BuySellServiceRequest;
use App\Redirect;
use App\Repositories\ShortsRepository;
use App\Services\CryptoCurrency\ShowCryptoCurrencyService;
use App\Session;

class BuyShortsService
{
    private ShowCryptoCurrencyService $showCryptoCurrencyService;

    public function __construct(
         $showCryptoCurrencyService
    )
    {
        $this->showCryptoCurrencyService = $showCryptoCurrencyService;
    }
    public function startBuy(BuySellServiceRequest $postUserData): Redirect
    {
        if($postUserData->getAmount()<=0){
            Session::put("message", "You can't buy 0 or less than 0");
            return new Redirect("/shorts");
        }

        $start = new ShortsRepository($this->showCryptoCurrencyService,);
        return $start->buyShorts($postUserData);
    }
}