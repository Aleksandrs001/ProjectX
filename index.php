<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Controllers\ShortsHistoryController;
use App\logout;
use App\Repositories\CoinMarketCapCryptoCurrencyRepository;
use App\Repositories\CryptoCurrenciesRepository;
use App\Session;
use App\Redirect;
use App\Template;
use Dotenv\Dotenv;
use Twig\Environment ;
use Twig\Loader\FilesystemLoader;
use App\Controllers\BuyController;
use App\Controllers\SellController;
use App\Controllers\ShortsController;
use App\Controllers\LoginController;
use App\Controllers\ProfileController;
use App\Controllers\HistoryController;
use App\Controllers\BuyShortsController;
use App\Controllers\SellShortsController;
use App\Controllers\ChangeEmailController;
use App\Controllers\RegistrationController;
use App\Controllers\CoinTransferController;
use App\Controllers\ChangePasswordController;
use App\Controllers\CryptoCurrencyController;

Session::initialize();

$dotenv = Dotenv::createImmutable('dotenv');
$dotenv->load();
$container = new DI\Container();
$container->set( CryptoCurrenciesRepository::class,
    \DI\create(CoinMarketCapCryptoCurrencyRepository::class)
);



$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) {
    $route->addRoute("GET", "/", [CryptoCurrencyController::class, "index"]);
    $route->addRoute("GET", "/crypto{symbol}", [CryptoCurrencyController::class, "showForm"]);
    $route->addRoute("POST", "/buy/crypto{symbol}", [BuyController::class, "buyCryptoCurrency"]);
    $route->addRoute("POST", "/sell/crypto{symbol}", [SellController::class, "sellCryptoCurrency"]);
    $route->addRoute("GET", "/coinTransfer", [CoinTransferController::class, "transfer"]);
    $route->addRoute("POST", "/coinTransfer", [CoinTransferController::class, "transferMoney"]);
    $route->addRoute("GET", "/registration", [RegistrationController::class, "showForm"]);
    $route->addRoute("GET", "/short", [ShortsController::class, "showForm"]);
    $route->addRoute("GET", "/shortsHistory", [ShortsHistoryController::class, "showForm"]);
    $route->addRoute("POST", "/buyShort", [BuyShortsController::class, "buyShorts"]);
    $route->addRoute("POST", "/sellShort", [SellShortsController::class, "sellShorts"]);
    $route->addRoute("POST", "/registration", [RegistrationController::class, "store"]);
    $route->addRoute("GET", "/login", [LoginController::class, "showForm"]);
    $route->addRoute("POST", "/login", [LoginController::class, "enter"]);
    $route->addRoute("GET", "/profile", [ProfileController::class, "showForm"]);
    $route->addRoute("GET", "/history", [HistoryController::class, "showForm"]);
    $route->addRoute("POST", "/profile", [ProfileController::class, "walletStatus"]);
    $route->addRoute("GET", "/logout", [logout::class, "logout"]);
    $route->addRoute("POST", "/changeEmail", [ChangeEmailController::class,"showForm"]);
    $route->addRoute("POST", "/changePassword", [ChangePasswordController::class,"changePassword"]);
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

//        $response = (new $controller)->{$method}($vars);
        $response = $container->get($controller)->{$method}($vars);

        if ($response instanceof Template) {
            echo $twig->render($response->getPath(), $response->getParams());
         unset($_SESSION['message']);
            break;
        }
        if ($response instanceof Redirect) {
            header("location:" . $response->getUrl());
//            unset($_SESSION["message"]);

            break;
        }
}
