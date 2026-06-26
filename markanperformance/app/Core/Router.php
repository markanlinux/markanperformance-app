<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $route, string $controllerClass): void
    {
        $this->routes[$route] = $controllerClass;
    }

    public function dispatch(string $route): void
    {
        $route = trim($route, "/");

        if ($route === "") {
            $route = "dashboard/index";
        }

        $parts    = explode("/", $route);
        $routeKey = $parts[0];
        $action   = $parts[1] ?? "index";

        if (!isset($this->routes[$routeKey])) {
            $this->notFound();
            return;
        }

        $controllerClass = $this->routes[$routeKey];
        $controller      = new $controllerClass();
        $method          = $this->toCamelCase($action);

        if (!method_exists($controller, $method)) {
            $this->notFound();
            return;
        }

        $controller->$method();
    }

    private function toCamelCase(string $action): string
    {
        $parts = explode("-", $action);
        $camel = $parts[0];

        for ($i = 1; $i < count($parts); $i++) {
            $camel .= ucfirst($parts[$i]);
        }

        return $camel;
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "<h1>404 - Stranica nije pronađena</h1>";
        echo "<p><a href='" . url() . "'>Povratak na početnu</a></p>";
        exit;
    }
}
