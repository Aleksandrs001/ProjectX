<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Models\LoginServiceRequest;
use App\Repositories\LoginRepository;
use App\Repositories\DatabaseRepository;

class LoginService
{

    public function getIn(string $login, string $password): Redirect
    {

        $resultSet = DatabaseRepository::getConnection()->executeQuery('SELECT * FROM users WHERE login = ?',
            [
                $login
            ]
        );
        $user = $resultSet->fetchAssociative();
        $objDB = new LoginServiceRequest(
            $user["id"],
            $user["name"],
            $user["login"],
            $user["email"],
            $user["password"],
            $user["avatar"]
        );
        $start = new LoginRepository($objDB);
        return $start->enter($password);
    }
}
