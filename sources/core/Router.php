<?php

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $path, string $controllerName, string $methodName): void
    {
        $this->routes[] = [
            "method" => "GET",
            "path" => $this->convertPathToRegex($path),
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function post(string $path, string $controllerName, string $methodName): void
    {
        $this->routes[] = [
            "method" => "POST",
            "path" => $this->convertPathToRegex($path),
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function start(): void
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];

        foreach ($this->routes as $route) {
            if ($method === $route["method"] && preg_match($route["path"], $path, $matches)) {
                $controllerName = $route["controllerName"];
                $methodName = $route["methodName"];

                require_once "controllers/$controllerName.php";

                $controller = new $controllerName();
                array_shift($matches); // Enlever le premier élément (l'URL complète)
                call_user_func_array([$controller, $methodName], $matches);

                return;
            }
        }

        // Si aucune route ne correspond
        http_response_code(404);
        echo "Page non trouvée.";
    }

    private function convertPathToRegex(string $path): string
    {
        return "#^" . preg_replace('/\{([^\/]+)\}/', '([^/]+)', $path) . "$#";
    }
}
