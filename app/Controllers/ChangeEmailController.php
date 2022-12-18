<?php declare(strict_types=1);

namespace App\Controllers;

use App\Session;
use App\Template;
use App\Redirect;
use App\Repositories\DatabaseRepository;

class ChangeEmailController
{

    public function showForm(): Template
    {
        $this->changeEmail();
        return new Template("login/login.twig");
    }

    public function changeEmail()
    {
        $oldEmail =(string) $_POST["oldEmail"];
        $newEmail =(string) $_POST["newEmail"];
        $reEmail =(string) $_POST["reEmail"];
        $accId =(string) $_SESSION["id"];
        $resultSet = DatabaseRepository::getConnection()->executeQuery('SELECT id, email FROM `crypto`.users WHERE id = ?', [$accId]);
        $user = $resultSet->fetchAssociative();

        if ($user["email"] == $oldEmail) {
            if ($newEmail === $reEmail) {
                if (1 == DatabaseRepository::getConnection()->executeQuery("SELECT email FROM `crypto`.users WHERE email = '$newEmail' ")->rowCount()) {
                    $_SESSION["message"] = "new Email already exist in DB";
                } else {
                    DatabaseRepository::getConnection()->Query(" UPDATE `crypto`.`users` SET `email` = '$newEmail' WHERE `id` = '$accId' ");
                    Session::put("message", "You successfully changed Email");
                }
            } else {
                Session::put("message", "New email and repeat email- not the same");
            }
            return new Redirect("/registration");
        } else {
            Session::put("message", "Incorrect Current Email");
        }
        return new Template("login/login.twig");
    }
}
