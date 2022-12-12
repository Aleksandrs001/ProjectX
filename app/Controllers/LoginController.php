<?php declare(strict_types=1);

namespace App\Controllers;

use App\Template;

class LoginController
{
    public function showForm(): Template
    {
        return new Template("login/login.twig");
    }
}
