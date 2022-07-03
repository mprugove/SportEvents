<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\User;
use App\Validation\UserValidator;
use Core\Input;

class UserController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->getCurrentUser()->isAdmin() || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        $this->view->render("User/index", [
            'users' => User::getAll()
        ]);
    }

    public function listAction()
    {
        // TO DO //
    }
}