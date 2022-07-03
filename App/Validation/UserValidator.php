<?php

declare(strict_types = 1);

namespace App\Validation;

use App\Model\User;

class UserValidator extends AbstractValidator
{
    public function validate(array $data): bool
    {
        $this->validateAddress($data['address']);
        $this->validateCity($data['city']);
        $this->validatePostcode($data['postcode']);
        $this->validateCountry($data['country']);

        return empty($this->getErrors());
    }

    public function validateUpdatedPassword(array $data): bool
    {
        $this->validatePassword($data['password']);

        return empty($this->getErrors());
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

    private function validateAddress(string $address): void
    {
        if (!empty($address))
        {
            if (strlen($address) < 2 || strlen($address) > 50)
            {
                $this->errors['address'] = "Please input a valid address.";
            }
        }
        else
        {
            $this->errors['address'] = "Please input an address.";
        }

        if (empty($this->errors['address']))
        {
            $this->data['address'] = $address;
        }
    }

    private function validateCity(string $city): void
    {
        if (!empty($city))
        {
            if (strlen($city) < 2 || strlen($city) > 50)
            {
                $this->errors['city'] = "Please input a valid city name.";
            }
        }
        else
        {
            $this->errors['city'] = "Please input a city name.";
        }

        if (empty($this->errors['city']))
        {
            $this->data['city'] = $city;
        }
    }

    private function validatePostcode(string $postcode): void
    {
        if (!empty($postcode))
        {
            if (strlen($postcode) < 2 || strlen($postcode) > 10)
            {
                $this->errors['postcode'] = "Please input a valid postal code.";
            }
        }
        else
        {
            $this->errors['postcode'] = "Please input a postcode.";
        }

        if (empty($this->errors['postcode']))
        {
            $this->data['postcode'] = $postcode;
        }
    }

    private function validateCountry(string $country): void
    {
        if (!empty($country))
        {
            if (strlen($country) < 2 || strlen($country) > 50)
            {
                $this->errors['country'] = "Please input a valid country name.";
            }
        }
        else
        {
            $this->errors['country'] = "Please input a country.";
        }

        if (empty($this->errors['country']))
        {
            $this->data['country'] = $country;
        }
    }
}
