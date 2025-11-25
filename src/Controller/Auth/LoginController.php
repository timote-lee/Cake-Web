<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Cake\Event\EventInterface;

use App\Controller\AppController;

class LoginController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // configure the login form and action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['showLoginForm', 'login']);
    }

    public function showLoginForm()
    {       
        // redirect to /home if authenticated
        if ($this->Authentication->getIdentity()) 
        {
            return $this->redirect(['_name' => 'home']);
        }


        $this->render('/auth/login');
    }

    public function login()
    {       
        $result = $this->Authentication->getResult();

        if (empty($result) || !$result->isValid()) 
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to login, try again later.'
                                    ]));
        }


        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'You have logged in successfully.'
                                ]));
    }

    public function logout()
    {
        $this->Authentication->logout();

        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'You have logged out successfully.'
                                ]));
    }
}
