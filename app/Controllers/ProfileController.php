<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Template;
use App\Redirect;
use App\Services\ProfileService;

class ProfileController
{
    public ProfileService $profileService;


    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function showForm(): Template
    {
        $totalMoneyInAccount = new profileService();
        return new Template("profile/profile.twig",
            [
                "items"=>$this->profileService->sumInWallet(),
            ]
        );
    }

    public function walletStatus(): Redirect
    {
        $putIntoDB = new Post ((float) $_POST["toMoneyBag"]);
        return $this->profileService->startMoneyCheckTransfer($putIntoDB->getPost());
    }
}
