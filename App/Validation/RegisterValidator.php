<?php

declare(strict_types = 1);

namespace App\Validation;

use App\Model\User;

class RegisterValidator extends AbstractValidator
{
    public function validate(array $data): bool
    {
        $this->validateName($data['username']);
        $this->validateEmail($data['email']);
        $this->validatePassword($data['password']);
        $this->validateConfirmPassword($data['password'], $data['confirm-password']);

        return empty($this->getErrors());
    }

    private function validateName(string $username): void
    {
        if (!empty($username) || !empty($lastName))
        {
            if (strlen($username) < 2 )
            {
                $this->errors['name'] = "Please enter a real name.";
            }
            elseif (strlen($username) > 50)
            {
                $this->errors['name'] = "Name is too long.";
            }
        }
        else
        {
            $this->errors['name'] = "You must enter your full name.";
        }

        if (empty($this->errors['name']))
        {
            $this->data['username'] = $username;
           
        }
    }

    private function validateEmail(string $email): void
    {
        if (!empty($email))
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $this->errors['email'] = "Invalid email provided.";
            }
            if (strlen($email) < 2)
            {
                $this->errors['email'] = "Email is too short.";
            }
            elseif (strlen($email) > 50)
            {
                $this->errors['email'] = "Email is too long.";
            }
            else
            {
                if (User::isEmailAvailable($email))
                {
                    $this->errors['email'] = "Email is already being used.";
                }
            }

            if (empty($this->errors['email']))
            {
                $this->data['email'] = $email;
            }
        }
        else
        {
            $this->errors['email'] = "You must enter an email.";
        }
    }

    private function validatePassword(string $password): void
    {
        if (!empty($password))
        {
            if (strlen($password) < 8)
            {
                $this->errors['password'] = "Password must be at least 8 characters long.";
            }
            if (strlen($password) > 50)
            {
                $this->errors['password'] = "Password must be less than 50 characters long.";
            }
            if (!preg_match("#[0-9]+#", $password))
            {
                $this->errors['password'] = "Password must have at least 1 number.";
            }
            if (!preg_match("#[A-Z]+#", $password))
            {
                $this->errors['password'] = "Password must have at least 1 uppercase character.";
            }
            if (!preg_match("#[a-z]+#", $password))
            {
                $this->errors['password'] = "Password must have at least 1 lowercase character.";
            }
        }
        else
        {
            $this->errors['password'] = "You must enter a password.";
        }
    }

    private function validateConfirmPassword(string $password, string $confirmPassword): void
    {
        if (!empty($confirmPassword))
        {
            if ($password != $confirmPassword)
            {
                $this->errors['confirm-password'] = "Passwords do not match.";
            }
        }
        else
        {
            $this->errors['confirm-password'] = "Please confirm password.";
        }
    }
}
