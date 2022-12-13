<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Controllers\CryptoCurrencyController;
use App\Controllers\LoginController;
use App\Controllers\ProfileController;
use App\Controllers\ReadyToBuyController;
use App\Controllers\RegistrationController;
use App\logout;
use App\Redirect;
use App\Services\LoginService;
use App\Services\ProfileService;
use App\Session;
use App\Template;
use Dotenv\Dotenv;
use Twig\Environment ;
use Twig\Loader\FilesystemLoader;

Session::initialize();

$dotenv = Dotenv::createImmutable('dotenv');
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute("GET", "/", [CryptoCurrencyController::class, "index"]);
    $route->addRoute("GET", "/crypto{symbol}", [CryptoCurrencyController::class, "showForm"]);
    $route->addRoute("POST", "/crypto{symbol}", [ReadyToBuyController::class, "buySell"]);
    $route->addRoute("GET", "/registration", [RegistrationController::class, "showForm"]);
    $route->addRoute("POST", "/registration", [RegistrationController::class, "store"]);
    $route->addRoute("GET", "/login", [LoginController::class, "showForm"]);
    $route->addRoute("POST", "/login", [LoginService::class, "getIn"]);
    $route->addRoute("GET", "/profile", [ProfileController::class, "showForm"]);
    $route->addRoute("POST", "/profile", [ProfileService::class, "moneyTransfer"]);
    $route->addRoute("GET", "/logout", [logout::class, "logout"]);
//    $route->addRoute("POST", "/changeEmail", [ChangeEmailController::class,"showForm"]);
//    $route->addRoute("POST", "/changePassword", [ChangePasswordController::class,"changePassword"]);
});

$loader = new FilesystemLoader('views');
$twig = new Environment($loader);
$twig->addGlobal("session", $_SESSION);


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}($vars);

        if ($response instanceof Template) {
            echo $twig->render($response->getPath(), $response->getParams());
//            var_dump($response);
         unset($_SESSION['message']);
            break;
        }
        if ($response instanceof Redirect) {
            header("location:" . $response->getUrl());
//            unset($_SESSION["message"]);

            break;
        }
}
