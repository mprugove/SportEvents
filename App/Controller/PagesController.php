<?php

declare(strict_types = 1);

namespace App\Controller;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

use App\Model\Event;
use App\Model\User;

class PagesController extends AbstractController
{
    public function indexAction(): void
    {
        $this->view->render('Pages/Index', [
            'users' => User::getAll()
        ]);
    }

    public function notFoundAction(): void
    {
        $this->view->render('Pages/404');
    }

    public function serverErrorAction(): void
    {
        $this->view->render('Pages/500');
    }
}
