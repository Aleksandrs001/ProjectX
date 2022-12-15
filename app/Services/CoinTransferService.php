<?php

namespace App\Services;

use App\Repositories\CoinsTransferRepository;

class CoinTransferService
{


    public function __construct($postDatas)
    {

       $a= new CoinsTransferRepository($postDatas);
    }


    public function Transfer($postDatas)
    {
//        var_dump($postDatas);die;
        $start=new CoinsTransferRepository($postDatas);

    }
//
//    public function getEmail(): string
//    {
//        return $this->email;
//    }
//
//    public function getLogin(): string
//    {
//        return $this->login;
//    }
//
//    public function getPassword(): string
//    {
//        return $this->password;
//    }


}