<?php declare(strict_types=1);

namespace App\Services;

use App\Models\LoginServiceRequest;
use App\Redirect;
use App\Repositories\DatabaseRepository;

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
            $_SESSION['id'] = $objDB->getId();
            $_SESSION["name"] = $objDB->getName();
            $_SESSION["login"] = $objDB->getLogin();
            $_SESSION["email"] = $objDB->getEmail();
            $_SESSION["avatar"] = $objDB->getAvatar();
            $_SESSION["message"] = "You successful login in";
            return new Redirect("/profile");
        } else {
            $_SESSION["message"] = "Login or password incorrect";
            return new Redirect("/login");
        }
    }
}
