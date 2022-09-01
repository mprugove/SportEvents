<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\AbstractModel;
use App\Model\Venue;
use App\Validation\VenueValidator;
use Core\Input;

class VanueController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function venuesAction()
    {

        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        $this->view->render('Admin/Venues/Venues', [
            'venues' => Venue::getAll()
        ]);
    }
}