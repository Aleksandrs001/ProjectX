<?php declare(strict_types=1);

use App\Redirect;

$a = new Redirect("/views/registration");
session_start();
session_destroy();
unset($_SESSION["error"]);
unset($_SESSION["message"]);
unset($_SESSION["id"]);
unset($_SESSION["login"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["avatar"]);

