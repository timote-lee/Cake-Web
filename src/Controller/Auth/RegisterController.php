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

        // configure actions to not require authentication, preventing
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
        $verificationsTable = $this->fetchTable('EmailVerifications');
        $usersTable         = $this->fetchTable('Users');
        
        $user = $usersTable->newEntity($this->request->getData(), ['validate' => 'register']);

        // validate
        if ($user->hasErrors())
        {   
            foreach ($user->getErrors() as $field => $messages)
            {
                foreach ($messages as $message)
                {
                    return $this->response->withType('application/json')
                                            ->withStringBody(json_encode([
                                                'status'  => 'error',
                                                'message' => str_replace(['field', '_'], [$field, ' '], $message)
                                            ]));
                }
            }
        }
        

        // check verification code
        $verification = $verificationsTable->find()
                                            ->where([
                                                'code' => $this->request->getData('verification_code')
                                            ])
                                            ->first();
        // verifiction code not exists
        if (!$verification)
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'The verification code is invalid.'
                                    ]));
        }

        // verification code is used
        if ($verification->used)
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'The verification code has been used.'
                                    ]));
        }

        // verification code expired after 30 minutes
        if (time() - $verification->created->getTimestamp() > 30 * 60)
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'The verification code is expired.'
                                    ]));
        }


        if (!$usersTable->save($user)) 
        {   
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to register, try again later.'
                                    ]));
        }


        $verification->used = date('Y-m-d H:i:s');
        $verificationsTable->save($verification);

        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'You have successfully registered.'
                                ]));
    }
}
