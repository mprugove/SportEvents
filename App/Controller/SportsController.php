<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Model\Sport;
use App\Validation\SportValidator;
use Core\Input;

class SportsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }
   
    public function sportsAction($id):void
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
        {
            $this->redirect('');
        }

        if($id)
        {
        $this->view->render('Sports/Sports', [
            'sports' => Sport::getAll('sport')
        ]);
    }
        else 
    
        {
            
            $this->view->render('Sports/Sports', [
                'sports'  => Sport::getAll('sport'),

            ]);
        }
    }

    public function addAction()
    {
        $this->redirect('admin/sports');
    }

    public function addSubmitAction()
    { 
        $this->session->resetFormInput();

        $validator = new SportValidator();
        $post = Input::validatePost();
        if($validator->validate($post))
        {
            $sport = ucfirst($post['sport']);

            Sport::insert([
                'sport' => $sport
            ]);
    
            $this->redirect('admin/sports');
        }
       else {
        $this->session->setFormData($validator->getData());
        $this->session->setFormErrors($validator->getErrors());
        $this->redirect('admin/sports');
       }
    }
    
    public function deleteSubmitAction($id)
    {
        if ($this->auth->getCurrentUser() === null || !$this->auth->isLoggedIn())
            {
                $this->redirect('');
            }
            
        Sport::delete('id', $id);
        $this->redirect('admin/sports');
    }
}