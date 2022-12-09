<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\RegisterServiceRequest;
use App\Redirect;
use App\Services\RegisterService;
use App\Template;

class RegistrationController
{

    public function showForm(): Template
    {
        return new Template("registration/registration.twig");
    }

    public function store(): Redirect
    {
        $registerService = new RegisterService();
        $registerService->execute(
            new RegisterServiceRequest(
                $_POST['name'],
                $_POST['login'],
                $_POST['email'],
                $_POST['password'],
                $_FILES['avatar']
            )
        );
        return new Redirect("/registration");
    }
}
