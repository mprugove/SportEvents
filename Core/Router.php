<?php

declare(strict_types=1);

namespace Core;

class Router
{
    private $request;
    private $route;

    private $defaultController = "Pages";
    private $defaultAction = "index";

    private const CONTROLLER_PREFIX = "\\App\\Controller\\";
    private const CONTROLLER_SUFFIX = "Controller";
    private const ACTION_SUFFIX = "Action";

    public function __construct(Request $request, Route $route)
    {
        $this->route = $route;
        $this->request = $request;
    }

    public function match(string $requestMethod, array $url)
    {
        //$regex = "#{(.*?)}#";
        $regex = '/\d+/';

        if (count($url) > 3)
        {
            throw new RouterException("Invalid URL.");
        }

        // Wildcard match - only accept digits
        if (isset($url[2]))
        {
            $param = ctype_digit($url[2]) ? $url[2] : "";
            $wildcard = preg_replace($regex, '{id}', $param ?? "");
            unset($url[2]);
            $urlToIdentify = empty($url[0]) ? '/' :  implode('/', $url) . '/' . $wildcard;
        }
        else
        {
            $urlToIdentify = empty($url[0]) ? '/' : rtrim(implode("/", $url), "/");
        }

        if (array_key_exists($urlToIdentify, $this->route->routes[$requestMethod]))
        {
            $routeParts = explode('@', $this->route->routes[$requestMethod][$urlToIdentify]);
            $controller = $routeParts[0] ?? $this->defaultController; // Pages
            $action = $routeParts[1] ?? $this->defaultAction; // index

            $this->dispatch($controller, $action, $param ?? null);
        }
        else
        {
            throw new RouterException("Invalid route.");
        }
    }

    public function dispatch(string $controller, string $action, string $param = null): void
    {
        $controller = self::CONTROLLER_PREFIX . ucfirst($controller) . self::CONTROLLER_SUFFIX;
        $action = $action . self::ACTION_SUFFIX;

        if (!class_exists($controller))
        {
            throw new RouterException("Controller does not exist.");
        }

        $controller = new $controller();

        if (!method_exists($controller, $action))
        {
            throw new RouterException("Action does not exist.");
        }

        $controller->$action($param);
    }
}
