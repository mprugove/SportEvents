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
   
    public function sportsAction():void
    {
        $this->view->render('Sports/Sports', [
            'sports' => Sport::getAll()
        ]);
    }

    public function addAction()
    {
        $this->redirect(('Sports/Sports'));
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
    
            $this->redirect('');
        }
       else {
        $this->session->setFormData($validator->getData());
        $this->session->setFormErrors($validator->getErrors());
        $this->redirect('Sports/Sports');
       }
    }
    
    public function deleteSubmitAction($id)
    {
        Sport::delete('id', $id);
        $this->redirect('');
    }
}