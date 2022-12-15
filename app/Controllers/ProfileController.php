<?php declare(strict_types=1);

namespace App\Controllers;

use App\Post;
use App\Template;
use App\Redirect;
use App\Services\ProfileService;

class ProfileController
{

    public function showForm(): Template
    {
        $totalMoneyInAccount = new profileService();
        $totalMoneyInAccount = $totalMoneyInAccount->sumInWallet();
        return new Template("profile/profile.twig",
            [
                "items"=>$totalMoneyInAccount,
            ]
        );
    }

    public function walletStatus(): Redirect
    {
        $putIntoDB = new Post ((float) $_POST["toMoneyBag"]);
        $start= new ProfileService();
        return $start->startMoneyCheckTransfer($putIntoDB->getPost());
    }
}
