<?php

declare (strict_types = 1);

namespace App\Validation;

use App\Model\Event;

class EventValidator extends AbstractValidator
{
    public function validate(array $data):bool
    {
        $this->validateEvent($data['event']);

        return empty($this->getErrors());
    }

    public function validateEvent($event)
    {
        if (empty($this->errors['event']))
        {
            $this->data['event'] = $event;
           
        }
    }
}