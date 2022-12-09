<?php declare(strict_types=1);

namespace App\Services;

use App\Models\CoinMarket;
use App\Models\Collections\CoinMarketCollection;
use App\Repositories\CoinMarketCapRepository;

class CoinMarketService
{
    public function execute(): CoinMarketCollection
    {
        $marketApiResponse = new CoinMarketCapRepository();
        $coinMarketData = $marketApiResponse->getCoinMarketData();
        $coinMarketCollection = new CoinMarketCollection();

        foreach ($coinMarketData->data as $data) {
            $coinMarketCollection->add(new CoinMarket(
                $data->id,
                $data->name,
                $data->symbol,
                $data->quote->USD->price,
                $data->quote->USD->percent_change_24h
            ));
        }
        return $coinMarketCollection;
    }
}