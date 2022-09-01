<?php

declare (strict_types = 1);

namespace App\Validation;

use App\Model\Sport;

class SportValidator extends AbstractValidator
{
    public function validate(array $data):bool
    {
        $this->validateSport($data['sport']);

        return empty($this->getErrors());
    }

    public function validateSport($sport)
    {
        if(strlen($sport) < 3)
        {
            $this->errors['sport'] = "Too short";
        }
        
        if(strlen($sport) > 25)
        {
            $this->errors['sport'] = "Too long";
        }

     
        if (empty($this->errors['sport']))
        {
           
            $this->data['sport'] = $sport;
        }
    }
}