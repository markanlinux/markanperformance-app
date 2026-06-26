<?php

use App\Core\Router;

define("PUBLIC_PATH", __DIR__);
define("APP_PATH", dirname(__DIR__) . "/app");
define("BASE_PATH", dirname(__DIR__) . "/");

$scriptDir = str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"]));
define("BASE_URL", rtrim($scriptDir, "/") . "/");

/**
 * Generira link prema ruti aplikacije, npr. url("cars/edit?id=5").
 * Svi linkovi idu kroz index.php?route=..., tako da aplikacija radi
 * bez potrebe za .htaccess / mod_rewrite (isto na Windowsu i Linuxu).
 */
function url(string $route = ""): string
{
    if ($route === "") {
        return BASE_URL;
    }

    [$path, $query] = array_pad(explode("?", $route, 2), 2, "");

    $url = BASE_URL . "?route=" . $path;

    if ($query !== "") {
        $url .= "&" . $query;
    }

    return $url;
}

spl_autoload_register(function ($class) {
    $relativePath = str_replace("App\\", "", $class);
    $relativePath = str_replace("\\", "/", $relativePath);

    $file = APP_PATH . "/" . $relativePath . ".php";

    if (file_exists($file)) {
        require $file;
    }
});

session_start();

$router = new Router();
$router->add("dashboard", \App\Controllers\DashboardController::class);
$router->add("auth",      \App\Controllers\AuthController::class);
$router->add("users",     \App\Controllers\UserController::class);
$router->add("cars",      \App\Controllers\CarController::class);

$route = $_GET["route"] ?? "dashboard";
$route = rtrim($route, "?");

$router->dispatch($route);
