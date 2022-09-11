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

        if(strlen($event) < 3)
        {
            $this->errors['event'] = "Too short";
        }

        if(empty($event))
        {
            $this->errors['event'] = "Cannot be empty";
        }

        if(empty($event))
        {
            $this->errors['start_time'] = 'Set up starting time';
        }


        if (empty($this->errors['event']))
        {
            $this->data['event'] = $event;
           
        }
    }
}