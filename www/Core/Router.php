<?php
namespace App\Core;

/**
 * Class Router
 * Gère le routing des requêtes vers les contrôleurs appropriés.
 */
class Router
{
    /**
     * @var array Liste des routes enregistrées
     */
    private $routes = [];

    /**
     * Lance le traitement de la requête actuelle.
     */
    public function run()
    {
        // Récupération de l'URL (paramètre 'q' via .htaccess ou REQUEST_URI)
        $uri = $_SERVER['REQUEST_URI'];
        
        // Nettoyage de l'URI (retirer les query params)
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        
        $this->defineRoutes();

        foreach ($this->routes as $route => $action) {
            // Conversion de la route en regex pour gérer les paramètres dynamiques
            // Exemple : /pages/{slug} devient /pages/([^/]+)
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Retirer la correspondance complète
                
                // $action est sous la forme 'Controller@method'
                list($controllerName, $method) = explode('@', $action);
                
                // Ajout du namespace complet
                $controllerClass = 'App\\Controllers\\' . $controllerName;
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $method)) {
                        // Appel de la méthode du contrôleur avec les paramètres extraits
                        call_user_func_array([$controller, $method], $matches);
                        return;
                    }
                }
            }
        }

        // Si aucune route ne correspond -> 404
        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Définit les routes de l'application.
     */
    private function defineRoutes()
    {
        $routesPath = ROOT . '/Config/routes.php';
        if (file_exists($routesPath)) {
            $this->routes = require $routesPath;
        } else {
            die("Fichier de routes introuvable.");
        }
    }
}
