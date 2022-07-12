<?php

declare(strict_types=1);

namespace Core;

class Route
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function __construct()
    {
        $this->register('GET', '/', 'Pages@index');
        $this->register('GET', '400', 'Pages@invalidRequest');
        $this->register('GET', '404', 'Pages@notFound');
        $this->register('GET', '500', 'Pages@serverError');

        $this->register('GET', 'Sports', 'Sports@Sports');
        $this->register('POST', 'Sports', 'Sports@addSubmit');
        $this->register('POST', 'sports/submit', 'Sports@addSubmit');
        
        $this->register('GET', 'Events', 'Events@events');
        $this->register('GET', 'Venues', 'Pages@venues');
        
        $this->register('POST', '', 'Register@registerSubmit');
        $this->register('POST', '', 'Login@loginSubmit');
        $this->register('GET', '', 'Login@logoutSubmit');

        $this->register('POST', 'register/submit', 'Register@registerSubmit');
        $this->register('POST', 'login/submit', 'Login@loginSubmit');
        $this->register('GET', 'login/logoutSubmit', 'Login@logoutSubmit');

        $this->register('GET', 'user', 'User@index');
    }

    private function register(string $method = 'GET', string $url = '/', string $controller = 'Pages'): void
    {
        $this->routes[$method][$url] = $controller;
    }
}
