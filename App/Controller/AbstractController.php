<?php

declare(strict_types = 1);

namespace App\Controller;

use Core\Session;
use Core\Auth;
use Core\View;

class AbstractController
{
    protected $view;
    protected $auth;
    protected $session;

    public function __construct()
    {
        $this->view = new View();
        $this->auth = Auth::getInstance();
        $this->session = Session::getInstance();
    }

    protected function redirect(string $location)
    {
        $location = strtolower($location);

        header('Location: ' . URL_ROOT . $location);
    }
}
