<?php

class Router
{
    private $routes = [];

    // GET request handler
    public function get($route, $callback)
    {
        $this->routes['GET'][$route] = $callback;
    }

    // POST request handler
    public function post($route, $callback)
    {
        $this->routes['POST'][$route] = $callback;
    }

    // Route işleme
    public function handle($method, $uri)
    {
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $callback) {
                // Parametreli route işleme
                $pattern = str_replace('/', '\/', $route);
                $pattern = preg_replace('/{([a-zA-Z]+)}/', '(?P<$1>[^\/]+)', $pattern);
                $pattern = '/^' . $pattern . '$/';

                if (preg_match($pattern, $uri, $matches)) {
                    // İlk eşleşen elemanı callback olarak işle
                    array_shift($matches); // İlk eleman tam eşleşmedir, çıkar
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    if (is_callable($callback)) {
                        call_user_func_array($callback, $params);
                    } else {
                        list($controller, $method) = explode('@', $callback);
                        $controllerInstance = new $controller();
                        call_user_func_array([$controllerInstance, $method], $params);
                    }
                    return;
                }
            }
        }

        // Eşleşen route yoksa 404 hatası döndür
        http_response_code(404);
        echo '404 Not Found';
    }
}
