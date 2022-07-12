<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Event;
use App\Validation\EventValidator;
use Core\Input;

class EventsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }
   
    public function eventsAction():void
    {
        $this->view->render('Events/Events', [
            'events' => Event::getAll()
        ]);
    }
}