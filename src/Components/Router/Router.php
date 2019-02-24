<?php

namespace JobApplication_2019_02_24\Components\Router;


class Router
{
    private $dependencyContainer;
    private $routes = [];
    private $currentRoute;
    private $requestMethod;
    private $requestUri;

    public function __construct($dependencyContainer)
    {
        $this->dependencyContainer = $dependencyContainer;
    }

    public function get($uri, $handler)
    {
        $this->routes[$uri]["GET"] = $handler;
    }

    public function handle()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = $_SERVER['REDIRECT_URL'];

        if (empty($this->requestUri)) {
            $this->requestUri = '/';
        }

        foreach ($this->routes as $route => $routInfo) {

            if (preg_match($this->prepareRoute($route), $this->requestUri, $matches)) {
                $this->currentRoute = $route;
            }
        }

        if (! $this->currentRoute) {
            throw new RouteNotFoundException('route not found');
        }

        if (! isset($this->routes[$this->currentRoute][$this->requestMethod])) {
            throw new MethodNotAllowedException('method not allowed');
        }

        $variables = $this->getVariables();

        $handler = explode('@', $this->routes[$this->currentRoute][$this->requestMethod]);

        $className = 'JobApplication_2019_02_24\Controllers\\' . $handler[1];
        $method = $handler[0];

        $controller = $this->dependencyContainer->get($className);

        if (! (method_exists($controller, $method))) {
            throw new InvalidMethodException();
        }

        $reflectionMethod = new \ReflectionMethod($className, $method);
        $methodParams = $reflectionMethod->getParameters();

        $dependencies = $this->getDependencies($methodParams, $variables);

        call_user_func_array([$controller, $method], $dependencies);
    }

    private function prepareRoute($route)
    {
        return '/^' . preg_replace(['/\{.*?\}/', '/\//'], ['(.*)', '\/'], $route) . '$/';
    }

    private function getVariables()
    {
        $variables = [];

        if (preg_match_all('/\{(.*?)\}/', $this->currentRoute, $names)) {
            $names = $names[1];
            preg_match($this->prepareRoute($this->currentRoute), $this->requestUri, $matches);
            foreach ($matches as $key => $match) {
                if (isset($names[$key - 1])) {
                    $variables[$names[$key - 1]] = $match;
                }
            }
        }

        return $variables;
    }

    private function getDependencies($parameters, $params = [])
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                // check if default value for a parameter is available
                if (isset($params[$parameter->getName()])) {
                    $dependencies[] = $params[$parameter->getName()];
                } elseif ($parameter->isDefaultValueAvailable()) {
                    // get default value of parameter
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                // get dependency resolved
                $dependencies[] = $this->dependencyContainer->get($dependency->name);
            }
        }

        return $dependencies;
    }
}