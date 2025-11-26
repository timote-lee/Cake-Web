<?php

declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{
    public function show()
    {
        $user = $this->Authentication->getIdentity();

        $this->set(compact('user'));
        $this->render('/users/show');
    }

    public function edit()
    {
        $user = $this->Authentication->getIdentity();

        $this->set(compact('user'));
        $this->render('/users/edit');
    }

    public function changePassword()
    {
        $user = $this->Authentication->getIdentity();

        $this->set(compact('user'));
        $this->render('/users/password');
    }

    public function update()
    {
        $user_id = $this->Authentication->getIdentity()->get('id');
        $user    = $this->Users->get($user_id);
        $user    = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'update']);

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


        if (!$this->Users->save($user)) 
        {   
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to update, try again later.'
                                    ]));
        }


        $this->Authentication->setIdentity($user);

        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'Your profile has been updated.'
                                ]));
    }

    public function updatePassword()
    {
        $user_id = $this->Authentication->getIdentity()->get('id');
        $user    = $this->Users->get($user_id);
        $user    = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'updatePassword']);

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


        $user->password = $this->request->getData('new_password');

        if (!$this->Users->save($user)) 
        {   
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to update, try again later.'
                                    ]));
        }


        $this->Authentication->setIdentity($user);

        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'Your password has been changed.'
                                ]));
    }
}
