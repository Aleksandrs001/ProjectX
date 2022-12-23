<?php declare(strict_types=1);

namespace App\Repositories;

use App\Session;
use App\Redirect;

class LoginRepository
{
    public object $objDB;

    public function __construct($objDB)
    {
        $this->objDB = $objDB;
    }
    public function enter(string $password): Redirect
    {
        if ($this->objDB->getLogin() == $this->objDB->getLogin() && $this->objDB->getPassword() == $password) {
            Session::put("id", $this->objDB->getId());
            Session::put("name", $this->objDB->getName());
            Session::put("login", $this->objDB->getLogin());
            Session::put("email", $this->objDB->getEmail());
            Session::put("avatar", $this->objDB->getAvatar());
            Session::put("message", "You successful login in");
            return new Redirect("/profile");
        } else {
            Session::put("message", "Login or password incorrect");
            return new Redirect("/login");
        }
    }
}