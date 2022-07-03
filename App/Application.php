<?php

declare(strict_types = 1);

namespace App;

use Core\Route;
use Core\Request;
use Core\Router;
use Core\RouterException;
use Exception;

class Application
{
    private $request;
    private $route;
    private $router;

    private const CONTROLLER = "pages";

    public function __construct()
    {
        $this->request = new Request();
        $this->route = new Route();
        $this->router = new Router($this->request, $this->route);
    }

    public function start(): void
    {
        try
        {
            $this->router->match($this->request->getRequestMethod(), $this->request->getUrlArray());
        }
        catch (RouterException $e)
        {
            http_response_code(404);
            $this->router->dispatch(self::CONTROLLER, "notFound");
        }
        catch (Exception $e)
        {
            http_response_code(500);
            $this->router->dispatch(self::CONTROLLER, "serverError");
        }
    }
}
