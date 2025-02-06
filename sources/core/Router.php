<?php
class Router {
    private array $routes;

class Router
{
    private array $routes;

    public function __construct() {
        $this->routes = [];
    }

    public function get(string $path, string $controllerName, string $methodName): void {
        $this->routes[] = [
            "method" => "GET",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }


    public function post(string $path, string $controllerName, string $methodName): void {
        $this->routes[] = [
            "method" => "POST",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function start(): void {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];

        // Supprimer les paramètres de requête de l'URL
        $path = strtok($path, '?');

        foreach ($this->routes as $route) {
            // Conversion du motif de route en expression régulière
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route["path"]);
            $pattern = "@^" . $pattern . "$@D";

            if ($method === $route["method"] && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Supprime la première correspondance (chemin complet)
                $methodName = $route["methodName"];
                $controllerName = $route["controllerName"];

                // Vérifier que la classe existe
                if (!class_exists($controllerName)) {
                    header("HTTP/1.0 500 Internal Server Error");
                    echo "Erreur : la classe {$controllerName} n'existe pas.";
                    return;
                }

                call_user_func_array([$controllerName, $methodName], $matches);
                return;
            }
        }
        
        // Route non trouvée
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . '/../views/404.php';
    }
}
