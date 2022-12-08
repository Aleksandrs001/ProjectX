<?php declare(strict_types=1);

namespace App\Controllers;

use App\Redirect;
use App\Repositories\DatabaseRepository;
use App\Template;

class ChangeEmailController
{

    public function showForm(): Template
    {
        $this->changeEmail();
        return new Template("login/login.twig");
    }

    public function changeEmail()
    {
        $oldEmail = $_POST["oldEmail"];
        $newEmail = $_POST["newEmail"];
        $reEmail = $_POST["reEmail"];
        $accId = $_SESSION["id"];
        $resultSet = DatabaseRepository::getConnection()->executeQuery('SELECT id, email FROM `news-api`.users WHERE id = ?', [$accId]);
        $user = $resultSet->fetchAssociative();

        if ($user["email"] == $oldEmail) {
            if ($newEmail === $reEmail) {
                if (1 == DatabaseRepository::getConnection()->executeQuery("SELECT email FROM `news-api`.users WHERE email = '$newEmail' ")->rowCount()) {
                    $_SESSION["message"] = "new Email already exist in DB";
                } else {
                    DatabaseRepository::getConnection()->Query(" UPDATE `news-api`.`users` SET `email` = '$newEmail' WHERE `id` = '$accId' ");
                    $_SESSION["message"] = "You successfully changed Email";
                }
            } else {
                $_SESSION["message"] = "New email and repeat email- not the same";
            }
            return new Redirect("/registration");
        } else {
            $_SESSION["message"] = "Incorrect Current Email";
        }
        return new Template("login/login.twig");
    }

}