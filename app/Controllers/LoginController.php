<?php declare(strict_types=1);

namespace App\Controllers;

use App\Template;
use App\Redirect;
use App\Services\LoginService;

class LoginController
{
    public function showForm(): Template
    {
        return new Template("login/login.twig");
    }
    public function enter(): Redirect
    {
        $login=(string) $_POST['login'];
        $password=md5((string) $_POST['password']);
        $start = new LoginService();
        return $start->getIn($login, $password);
    }
}
