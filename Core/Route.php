<?php

declare(strict_types=1);

namespace Core;

use App\Controller\SportsController;

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

        $this->register('GET', 'admin/events', 'Admin@events');
        $this->register('GET', 'admin/sports', 'Admin@sports');
        $this->register('GET', 'admin/venues', 'Admin@venues');
        $this->register('GET', 'admin/list', 'Admin@getList');

        $this->register('GET', 'Venues', 'Venues@venues');
        
        $this->register('GET', 'Events', 'Events@events');
        $this->register('POST', 'Events', 'Events@addSubmit');
        $this->register('POST', 'Events/submit', 'Events@addSubmit');
        $this->register('POST', 'Events/deleteSubmit/{id}', 'Events@deleteSubmit');
  
        $this->register('GET', 'Sports', 'Sports@sports');
        $this->register('POST', 'Sports', 'Sports@addSubmit');
        $this->register('POST', 'Sports/submit', 'Sports@addSubmit');
        $this->register('POST', 'Sports/deleteSubmit/{id}', 'Sports@deleteSubmit');

        $this->register('POST', '', 'Register@registerSubmit');
        $this->register('POST', '', 'Login@loginSubmit');
        $this->register('GET', '', 'Login@logoutSubmit');

        $this->register('POST', 'register/submit', 'Register@registerSubmit');
        $this->register('POST', 'login/submit', 'Login@loginSubmit');
        $this->register('GET', 'login/logoutSubmit', 'Login@logoutSubmit');

        $this->register('GET', 'user', 'User@index');
        $this->register('GET','user/edit/{id}','User@edit');
        $this->register('POST', 'user/updatePasswordSubmit/{id}', 'User@updatePasswordSubmit');
    }

    private function register(string $method = 'GET', string $url = '/', string $controller = 'Pages'): void
    {
        $this->routes[$method][$url] = $controller;
    }
}
