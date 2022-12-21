<?php
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
}