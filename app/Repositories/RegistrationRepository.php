<?php declare(strict_types=1);

namespace App\Repositories;

use App\Redirect;
use App\Session;

class RegistrationRepository
{
    public function registrationCheck($request): Redirect
    {
        $userEmail = $request->getEmail();
        $emailFrom_DB = DatabaseRepository::getConnection()->executeQuery("SELECT email FROM users WHERE email = '$userEmail' ")->rowCount();
        if ($emailFrom_DB == 1) {
            Session::put("message", "This email or login  already in DB");
            return new Redirect("/registration");
        }
        $userLogin = $request->getLogin();
        $loginFrom_DB = DatabaseRepository::getConnection()->executeQuery("SELECT login FROM users WHERE login = '$userLogin' ")->rowCount();
        if ($loginFrom_DB == 1) {
            Session::put("message", "This email or login  already in DB");
            return new Redirect("/registration");
        }
        if ($request->getPassword() == $request->getRepeatPassword()) {
            DatabaseRepository::getConnection()->insert('users', [
                'name' => $request->getName(),
                'login' => $request->getLogin(),
                'email' => $request->getEmail(),
                'password' => md5($request->getPassword()),
                'avatar' => $request->getAvatar()
            ]);
            Session::put("message", "You have successfully registered");
            return new Redirect("/login");
        } else {
            Session::put("message", "Passwords are not the same");
        }
        return new Redirect("/registration");
    }
}