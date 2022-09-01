<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Event;
use App\Model\Sport;
use App\Model\Venue;
use App\Validation\EventValidator;
use Core\Input;

class EventsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }
   
    public function eventsAction($id):void
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        if($id)
        {
            
        
        $this->view->render('Events/Events', [
            'events' => Event::getAll()
          
        ]);
        }
        else 
        {
            $sports = Event::getEventSport($id);
            $this->view->render('Events/Events', [
                'events'  => Event::getAll(),
                'sports' => $sports,
            ]);
        }
    }

    public function addAction()
    {
        $this->redirect('admin/events',[
            'sports' => Sport::getAll(),
            'venus' => Venue::getAll()
        ]);
    }

    public function addSubmitAction()
    {
        $this->session->resetFormInput();

        $validator = new EventValidator();
        $post = Input::validatePost();
        if($validator->validate($post))
        {
            $event = ucfirst($post['event']);
            $description = ucfirst($post['description']);
            $startDate = $post['start-date'];
            $endDate = $post['end-date'];
            $startTime = $post['start-time'];
            $endTime = $post['end-time'];
            $sportId = $post['sport'];
            $venueId = $post['venues'];

            $eventId = Event::insert([
                'event' => $event,
                'description' => $description,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $startTime,
                'end_time' => $endTime 
            ]);

            $event = Event::getOne('id', $eventId);
            Event::addSportToEvent($event->getId(), $sportId);
            Event::addVenuetoEvent($event->getId(), $venueId);

            $this->redirect('admin/events');
        } else {
            $this->session->setFormData($validator->getData());
            $this->session->setFormErrors($validator->getErrors());
            $this->redirect('admin/events');
        }
    }

    public function deleteSubmitAction($id):void
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        Event::delete('id', $id);
        $this->redirect('admin/events');

    }
}