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
       $items=0;

        foreach ($user as $item){
            $items+=(int)$item["money_bag"];
        }

        return $items;
    }

    public function showForm(): Template
    {

        $items = $this->getTotalInMoneyBag();
        return new Template("profile/profile.twig", ["userData"=>$this->walletStatus()->all(),"items"=>$items]);
    }

    public function walletStatus(): CryptoCurrenciesCollection
    {

        $id = $_SESSION["id"];
        $portfolio = DatabaseRepository::getConnection()->executeQuery('SELECT coin_symbol,
       coin_amount,
       coin_price,
       buy_date,
       sell_date,
       money_bag 
FROM users_crypto_profiles WHERE user_id =?', [$id]);

        $usersInfo = $portfolio->fetchAllAssociative();

        $createUserPortfolioRequest = new CryptoCurrenciesCollection();
        foreach ($usersInfo as $userInfo) {
            $createUserPortfolioRequest->add(new ProfileServiceRequest(
                    $userInfo["coin_symbol"],
                    $userInfo["coin_amount"],
                    $userInfo["coin_price"],
                    $userInfo["buy_date"],
                    $userInfo["sell_date"],
                    $userInfo["money_bag"],
                )
            );
        }

        return $createUserPortfolioRequest;
    }


}
