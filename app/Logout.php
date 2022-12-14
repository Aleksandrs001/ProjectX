<?php declare(strict_types=1);

namespace App;

class Logout
{
    public function logout(): Redirect
    {
        unset($_SESSION["error"]);
        unset($_SESSION["message"]);
        unset($_SESSION["id"]);
        unset($_SESSION["login"]);
        unset($_SESSION["name"]);
        unset($_SESSION["email"]);
        unset($_SESSION["avatar"]);
        unset($_SESSION["greetings"]);
        if (!isset($_SESSION["id"]))Session::put("id", "1");
        return new Redirect("/");
    }
}

