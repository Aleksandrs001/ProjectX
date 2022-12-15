<?php

namespace App\Repositories;

use App\Session;
use App\Redirect;

class RegistrationRepository
{
    public function registrationCheck($request): Redirect
    {
        $userEmail = $request->getEmail();
        $emailFrom_DB = DatabaseRepository::getConnection()->executeQuery("SELECT email FROM users WHERE email = '$userEmail' ")->rowCount();
        if ($emailFrom_DB == 1) {
            Session::put("errorMessage", "This email already in DB");
            return new Redirect("/registration");
        }
        $userLogin = $request->getLogin();
        $loginFrom_DB = DatabaseRepository::getConnection()->executeQuery("SELECT login FROM users WHERE login = '$userLogin' ")->rowCount();
        if ($loginFrom_DB == 1) {
            Session::put("errorMessage", "This login already in DB");
            return new Redirect("/registration");
        }

        DatabaseRepository::getConnection()->insert('users', [
            'name' => $request->getName(),
            'login' => $request->getLogin(),
            'email' => $request->getEmail(),
            'password' => md5($request->getPassword()),
            'avatar' => $request->getAvatar()
        ]);
        $registeredLogin = $request->getLogin();
        if (1 == DatabaseRepository::getConnection()->executeQuery("SELECT login FROM users WHERE login = '$registeredLogin' ")->rowCount()) {

            $_SESSION['greetings'] = "{$request->getname()} you successfully registered.";
            return new Redirect("/registration");
        }
        return new Redirect("/registration");
    }
}