<?php

declare(strict_types = 1);

namespace App\Validation;

abstract class AbstractValidator
{
    protected $data = [];
    protected $errors = [];

    abstract function validate(array $data);

    public function getData(): array
    {
        return $this->data;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
