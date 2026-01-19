<?php

/**
 * Router class
 * Handles routing logic and dispatches requests to appropriate controllers
 */
class Router
{
    private array $routes = [];
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Add a route to the router
     */
    public function add(string $action, string $controllerClass, string $method, string $modelClass): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method' => $method,
            'model' => $modelClass
        ];
    }

    /**
     * Dispatch request to appropriate controller
     */
    public function dispatch(?string $action = null): void
    {
        $action = $action ?? $_GET['action'] ?? 'home';

        if (!isset($this->routes[$action])) {
            $this->redirect404();
            return;
        }

        $route = $this->routes[$action];

        // Instantiate model
        $model = new $route['model']($this->database);

        // Instantiate controller
        $controller = new $route['controller']($model);

        // Call method
        $method = $route['method'];
        $controller->$method();
    }

    /**
     * Redirect to home on 404
     */
    private function redirect404(): void
    {
        header('Location: index.php?action=home');
        exit;
    }
}
