<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProfileService;
use App\Template;
use App\Services\CoinTransferService;
use App\Models\CoinTransferServiceRequest;

class CoinTransferController
{
    public array $start;
    private ProfileService $profileService;

    public function __construct(
        ProfileService $profileService
    )
    {
        $this->profileService = $profileService;
    }

    public function transfer(): Template
    {
        $start = new CoinTransferService();
        return new Template("coinTransfer/transfer.twig", [
            "start" => $start->showUserAccinfo()->all(),
                "items"=>$this->profileService->sumInWallet(),
        ]
        );
    }

    public function transferCoins(): object
    {
        $postUserForm = new CoinTransferServiceRequest(
            (string) $_POST["login"],
            (string) $_POST["email"],
            (string) $_POST["password"],
            (int) $_POST["recipient"],
            (float) $_POST["amount"],
            (string) $_POST["currency"]
        );
        $start = new CoinTransferService();
        return $start->transfer($postUserForm);
    }
}
