<?php declare(strict_types=1);
namespace App\Services;

use App\Repositories\HistoryRepository;
use App\Models\Collections\CryptoCurrenciesCollection;

class HistoryService
{
    public function showHistory(): CryptoCurrenciesCollection
    {
        $history = new HistoryRepository();
        return $history->showAllTransactions();
    }

    public function showSymbolAmountAndPrice(): CryptoCurrenciesCollection
    {
        $history = new HistoryRepository();
        return $history->showSymbolAmountAndPrice();
    }
}