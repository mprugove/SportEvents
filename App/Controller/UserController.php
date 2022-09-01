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

        $userId = $this->auth->getCurrentUser()->getId();

        $this->view->render("User/index", [
            'users' => User::getMultiple('id', $userId)
        ]);
    }

    public function editAction()
    {
        if($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }
       
        $userId = $this->auth->getCurrentUser()->getId();

        $this->view->render("User/edit", [
            'users' => User::getOne('id', $userId)
        ]);
    }

    public function updatePasswordSubmitAction($id)
    {
        if($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        $validator = new UserValidator();
        $post = Input::validatePost();

        $this->session->resetFormInput();

        if($validator->validateUpdatedPassword($post))
        {
            $password = password_hash($post['password'], PASSWORD_DEFAULT);
            User::update(['password' => $password], 'id', $id);
            $this->redirect(''); 
        }
        else
        {
            $this->session->setFormData($validator->getData());
            $this->session->setFormErrors($validator->getErrors());

            $this->redirect('User/edit');
        }
    }
}