<?php

class Router
{
    private array $routes;

    public function __construct() {
        $this->routes = [
            "GET" => [],
            "POST" => []
        ];
    }

    public function get(string $path, string $controllerName, string $methodName): void {
        $this->routes["GET"][$path] = [
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function post(string $path, string $controllerName, string $methodName): void {
        $this->routes["POST"][$path] = [
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function start(): void {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];
        $path = strtolower($path);
        // Supprimer les paramètres de requête de l'URL
        $path = strtok($path, '?');

        //var_dump($method, $path, $this->routes);
        // exit();

        // Vérifier si la route existe
        if (!isset($this->routes[$method][$path])) {
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../views/404.php';
            exit();
        }

        $route = $this->routes[$method][$path];
        $controllerName = $route["controllerName"];
        $methodName = $route["methodName"];

        // Vérifier que la classe existe
        if (!class_exists($controllerName)) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Erreur : la classe {$controllerName} n'existe pas.";
            exit();
        }

        // Vérifier que la méthode existe dans le contrôleur
        if (!method_exists($controllerName, $methodName)) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Erreur : la méthode {$methodName} n'existe pas dans le contrôleur {$controllerName}.";
            exit();
        }

        // Instancier le contrôleur et appeler la méthode
        $controllerInstance = new $controllerName();
        call_user_func([$controllerInstance, $methodName]);
    }

}
