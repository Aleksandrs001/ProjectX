<?php declare(strict_types=1);

namespace App\Services;

use App\Models\LoginServiceRequest;
use App\Redirect;
use App\Repositories\DatabaseRepository;
use App\Session;

class LoginService
{
    public function getIn(): Redirect
    {
        $login = $_POST["login"];
        $password = md5($_POST["password"]);

        $resultSet = DatabaseRepository::getConnection()->executeQuery('SELECT * FROM users WHERE login = ?', [$login]);
        $user = $resultSet->fetchAssociative();
        $objDB = new LoginServiceRequest(
            $user["id"],
            $user["name"],
            $user["login"],
            $user["email"],
            $user["avatar"]
        );
        if ($login == $user["login"] && $user["password"] == $password) {
            Session::put("id", $objDB->getId());
            Session::put("name", $objDB->getName());
            Session::put("login", $objDB->getLogin());
            Session::put("email", $objDB->getEmail());
            Session::put("avatar", $objDB->getAvatar());
            Session::put("message", "You successful login in");
            return new Redirect("/profile");
        } else {
            Session::put("message", "Login or password incorrect");
            return new Redirect("/login");
        }
    }
}
