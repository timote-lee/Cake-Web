<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use ModelAwareTrait;

use Cake\Event\EventInterface;

use App\Controller\AppController;

class RegisterController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // configure the login form and action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['showRegisterForm', 'register']);
    }

    public function showRegisterForm()
    {
        // redirect to /home if authenticated
        if ($this->Authentication->getIdentity()) 
        {
            return $this->redirect(['_name' => 'home']);
        }


        $this->render('/auth/register');
    }

    public function register()
    {
        $users = $this->fetchTable('Users');
        $user  = $users->newEntity($this->request->getData());

        if ($user->hasErrors())
        {   
            foreach ($user->getErrors() as $field => $messages)
            {
                foreach ($messages as $message)
                {
                    return $this->response->withType('application/json')
                                            ->withStringBody(json_encode([
                                                'status'  => 'error',
                                                'message' => str_replace('field', $field, $message)
                                            ]));
                }
            }
        }
        

        if (!$users->save($user)) 
        {   
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to register, try again later.'
                                    ]));
        }


        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'You have successfully registered.'
                                ]));
    }
}
