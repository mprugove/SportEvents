<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\User;
use App\Validation\RegisterValidator;
use Core\Input;

class RegisterController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registerAction()
    {
        $this->redirect('#register');
    }

    public function registerSubmitAction()
    {
        // Clear errors and data if they exist for next validation
        $this->session->resetFormInput();

        $validator = new RegisterValidator();
        $post = Input::validatePost();

        if ($validator->validate($post))
        {
            // Formatting
            // Example: jOHN to John
            //          EMAil@emAIL.COm to email@email.com
            $username = ucfirst(strtolower($post['username']));
            $email = strtolower($post['email']);
            $password = password_hash($post['password'], PASSWORD_DEFAULT);

            User::insert([
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);

            $this->redirect('');
        }
        else
        {
            // Pass all discovered errors and valid data to session and redirect back to form
            $this->session->setFormData($validator->getData());
            $this->session->setFormErrors($validator->getErrors());
            $this->redirect('#register');
        }
    }
}
