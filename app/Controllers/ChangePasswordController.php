<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Collections\ChangePasswordServiceCollection;
use App\Redirect;
use App\Services\ChangePasswordService;

class ChangePasswordController
{

    public function changePassword(): Redirect
    {
        $userInfo = new ChangePasswordServiceCollection($_POST["oldPassword"],
            $_POST["newPassword"],
            $_POST["reNewPassword"],
            $_SESSION["id"]
        );
        new ChangePasswordService($userInfo);
        return new Redirect("/login");
    }
}
