<?php

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
   
    public function eventsAction($id)
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        if(!$id)
        {
                $sports = Event::getAll();
                $venue = Event::getAll();
                $events = Event::getAll();
                $this->view->render('Events/Events', [
                    'events'  => $events,
                    'venues' => $venue
        ]);
        }
        else 
        {
                 $this->redirect('');
        }
    }

    public function addAction()
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->getCurrentUser()->isAdmin() || !$this->auth->isLoggedIn())

        {
            $this->redirect('');
        }
        $this->view->render('Admin/events',[
            'sports' => Sport::getAll(),
            'venues' => Venue::getAll()
        ]);
    }

    public function addSubmitAction()
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->getCurrentUser()->isAdmin() || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        $this->session->resetFormInput();
        
        $validator = new EventValidator();
        $post = Input::validatePost();

        if($validator->validate($post))
        {
            $event = ucfirst($post['event']);
            $description = ucfirst($post['description']);
            $startDate = $post['start-date'];
            $startTime = $post['start-time'];
            $sportId = $post['sport'];
            $venueId = $post['venues'];

            $eventId = Event::insert([
                'event' => $event,
                'description' => $description,
                'start_date' => $startDate,
                'start_time' => $startTime,
                'sport_id' => $sportId,
                'venue_id' => $venueId
            ]);
/*
            $event = Event::getOne('id', $eventId);
            Event::addSportToEvent($event->getId(), $sportId);
            Event::addVenueToEvent($event->getId(), $venueId);
*/
            $this->redirect('admin/events');

        } else
        {
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