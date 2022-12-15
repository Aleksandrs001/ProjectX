<?php
namespace App\Services;

use App\Repositories\HistoryRepository;

class HistoryService
{
    public function showHistory(): array
    {
        $history = new HistoryRepository();
        $history = $history->showAllTransactions();
        return $history->all();
    }
}