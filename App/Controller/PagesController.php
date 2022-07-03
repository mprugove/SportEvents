<?php

declare(strict_types = 1);

namespace App\Controller;

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
