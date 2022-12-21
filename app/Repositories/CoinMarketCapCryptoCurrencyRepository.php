<?php declare(strict_types=1);

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Models\CryptoCurrency;
use App\Models\Collections\CryptoCurrenciesCollection;

class CoinMarketCapCryptoCurrencyRepository implements CryptoCurrenciesRepository
{

    private const API_URL = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/';
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(["base_uri" => self::API_URL]);
    }

    public function fetchAllBySymbols(array $symbols): CryptoCurrenciesCollection
    {
        $response = $this->httpClient->request('GET', 'quotes/latest', [
            "headers" => [
                "Accepts" => "application/json",
                "X-CMC_PRO_API_KEY" => $_ENV["SECRET_KEY"]
            ],
            "query" => [
                "symbol" => implode(",",$symbols),
                "convert" => "USD"
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());

       $cryptoCurrencies = new CryptoCurrenciesCollection();

        foreach ($response->data as $currency) {
            $cryptoCurrencies->add(new CryptoCurrency(
                    $currency->symbol,
                    $currency->name,
                    $currency->quote->USD->price,
                    $currency->quote->USD->percent_change_1h,
                    $currency->quote->USD->percent_change_24h,
                    $currency->quote->USD->percent_change_7d
                )
            );
        }
        return $cryptoCurrencies;
    }

    public function fetchBySymbol(string $symbol): CryptoCurrency
    {
        $response = $this->httpClient->request('GET', 'quotes/latest', [
            "headers" => [
                "Accepts" => "application/json",
                "X-CMC_PRO_API_KEY" => $_ENV["SECRET_KEY"]
            ],
            "query" => [
                "symbol" => $symbol,
                "convert" => "USD"
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());

        $currency = $response->data->$symbol;

        return new CryptoCurrency(
            $currency->symbol,
            $currency->name,
            $currency->quote->USD->price,
            $currency->quote->USD->percent_change_1h,
            $currency->quote->USD->percent_change_24h,
            $currency->quote->USD->percent_change_7d
        );
    }

    public function fetchQuote(string $symbol): Quote
    {
        $response = $this->httpClient->request('GET', 'quotes/latest', [
            "headers" => [
                "Accepts" => "application/json",
                "X-CMC_PRO_API_KEY" => $_ENV["SECRET_KEY"]
            ],
            "query" => [
                "symbol" => $symbol,
                "convert" => "USD"
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());

        $currency = $response->data->$symbol;

        return new Quote(
            $currency->quote->USD->price,
            $currency->quote->USD->percent_change_1h,
            $currency->quote->USD->percent_change_24h,
            $currency->quote->USD->percent_change_7d
        );
    }
}
