<?php declare(strict_types=1);

namespace App\Controllers;

use App\Template;
use App\Redirect;
use App\Services\RegistrationService;
use App\Models\RegisterServiceRequest;

class RegistrationController
{

    public function showForm(): Template
    {
        return new Template("registration/registration.twig");
    }

    public function store(): Redirect
    {

        $registerService = new RegistrationService();
        $registerService->execute(
            new RegisterServiceRequest(
                (string) $_POST['name'],
                (string)   $_POST['login'],
                (string) $_POST['email'],
                (string) $_POST['password'],
                (array)  $_FILES['avatar']
            )
        );
        return new Redirect("/registration");
    }
}
