<?php declare(strict_types=1);

namespace App\Services;

use App\Redirect;
use App\Repositories\DatabaseRepository;
use App\Session;

class ChangePasswordService
{
    public function __construct($userInfo)
    {
        $resultSet = DatabaseRepository::getConnection()->executeQuery('SELECT password FROM users WHERE id = ?', [$userInfo->getId()]);
        $user = $resultSet->fetchAssociative();

        if ($user["password"] == $userInfo->getCurrentPassword()) {
            if ($userInfo->getNewPassword() == $userInfo->getReNewPassword()) {
                DatabaseRepository::getConnection()->Query(" UPDATE users SET `password` = '{$userInfo->getNewPassword()}' WHERE `id` = '{$userInfo->getId()}' ");
                Session::put("message", "You successfully changed Password");
                return new Redirect("/login");
            } else {
                Session::put("message", "New Password and Repeat Password doesn't not match");
                return new Redirect("/login");
            }
        } else {
            Session::put("message", "Current Password doesn't match new Password!");
            return new Redirect("/login");
        }
    }
}
