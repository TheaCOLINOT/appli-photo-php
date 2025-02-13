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
        $this->routes["GET"][] = [
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function post(string $path, string $controllerName, string $methodName): void {
        $this->routes["POST"][] = [
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function start(): void {
        $method = $_SERVER["REQUEST_METHOD"];
        $uri = $_SERVER["REQUEST_URI"];
        $uri = strtolower($uri);

        // Supprimer les paramètres de requête de l'URL
        $uri = strtok($uri, '?');

        // Vérifier les routes
        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([^/]+)', $route["path"]);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Supprime le premier élément (URL complète)

                $controllerName = $route["controllerName"];
                $methodName = $route["methodName"];

                if (!class_exists($controllerName)) {
                    header("HTTP/1.0 500 Internal Server Error");
                    echo "Erreur : la classe {$controllerName} n'existe pas.";
                    exit();
                }

                if (!method_exists($controllerName, $methodName)) {
                    header("HTTP/1.0 500 Internal Server Error");
                    echo "Erreur : la méthode {$methodName} n'existe pas dans le contrôleur {$controllerName}.";
                    exit();
                }

                $controllerInstance = new $controllerName();
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }

        // Si aucune route ne correspond, afficher une erreur 404
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../views/404.php';
        exit();
    }
}
