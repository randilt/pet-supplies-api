<?php
class Router
{
    private $routes = [];

    // Method to register routes
    public function register(string $method, string $route, callable $action)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'action' => $action
        ];
        return $this;
    }

    // Dispatch method
    public function dispatch(string $requestMethod, string $uri)
    {
        foreach ($this->routes as $route) {
            // Check if the method matches
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Convert route with parameters to a regex pattern
            $pattern = $this->convertRouteToRegex($route['route']);

            // Check if the URI matches the route pattern
            if (preg_match($pattern, $uri, $matches)) {
                // Remove the full match (index 0)
                array_shift($matches);

                // Call the action with matched parameters
                return call_user_func_array($route['action'], $matches);
            }
        }

        // Handle 404 if no route is found
        http_response_code(404);
        echo "404 Not Found";
        exit;
    }

    // Helper method to convert route to regex
    private function convertRouteToRegex(string $route): string
    {
        // Replace {param} with regex capture groups
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }
}

// Example usage
$router = new Router();

$router->register('GET', 'products/{id}', function ($id) {
    // Your product detail logic
    echo "Product ID: " . htmlspecialchars($id);
});

$router->register('GET', 'products', function () {
    // Your product list logic
    echo "Product List";
});