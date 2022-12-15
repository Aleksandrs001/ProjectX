<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Collections\CryptoCurrenciesCollection;
use App\Models\ProfileServiceRequest;
use App\Repositories\DatabaseRepository;
use App\Template;

class ProfileController
{

    public function getTotalInMoneyBag(): int
    {

        $resultSet=  DatabaseRepository::getConnection()->executeQuery(
            'select money_bag from users_crypto_profiles where user_id = ?', [ $_SESSION["id"] ]);
        $user = $resultSet->fetchAllAssociative();
       $totalMoneyInAccount=0;

        foreach ($user as $item){
            $totalMoneyInAccount+=(int)$item["money_bag"];
        }

        return $totalMoneyInAccount;
    }

    public function showForm(): Template
    {

        $totalMoneyInAccount = $this->getTotalInMoneyBag();
        return new Template("profile/profile.twig",
            [
                "userData"=>$this->walletStatus()->all(),
                "items"=>$totalMoneyInAccount
            ]
        );
    }

    public function walletStatus(): CryptoCurrenciesCollection
    {
        $id = $_SESSION["id"];
        $portfolio = DatabaseRepository::getConnection()->executeQuery('SELECT coin_symbol,
       coin_amount,
       coin_price,
       date,
       money_bag 
FROM users_crypto_profiles WHERE user_id =?', [$id]);

        $usersInfo = $portfolio->fetchAllAssociative();

        $createUserPortfolioRequest = new CryptoCurrenciesCollection();
        foreach ($usersInfo as $userInfo) {
            $createUserPortfolioRequest->add(new ProfileServiceRequest(
                    $userInfo["coin_symbol"],
                    $userInfo["coin_amount"],
                    $userInfo["coin_price"],
                    $userInfo["date"],
                    $userInfo["money_bag"],
                )
            );
        }
        return $createUserPortfolioRequest;
    }
}
