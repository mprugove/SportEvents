<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\User;
use App\Model\Event;
use App\Model\Sport;
use App\Model\Venue;
use Core\Input;

class AdminController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if($this->auth->getCurrentUser() === null || !$this->auth->getCurrentUser()->isAdmin())
        {
            $this->redirect('');
        }
    }

    public function getListAction()
    {
        $this->view->render("Admin/List", [
            'admins' => User::getMultiple('is_admin', 1),
            'users' => User::getMultiple('is_admin', 0)
        ]);
    }

    public function eventsAction($id)
    {

            $this->view->render('Admin/events/events', [
                'events'  => Event::getAll(),
                'sports' => Sport::getAll('sport'),
                'venues' => Venue::getAll('venue')
                
            ]);
        
    }

    public function sportsAction()
    {
        $this->view->render("admin/sports/sports", [
            'sports' => Sport::getAll('sport')
        ]);
    }

    public function venuesAction()
    {
        
        $this->view->render('Admin/Venues/venues', [
            'venues' => Venue::getAll()
        ]);
    }
}