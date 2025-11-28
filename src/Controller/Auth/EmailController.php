<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Cake\Mailer\Mailer;
use Cake\Event\EventInterface;

use App\Controller\AppController;

class EmailController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // configure actions to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['send']);
    }

    public function send()
    {   
        $verificationsTable = $this->fetchTable('EmailVerifications');
        $usersTable         = $this->fetchTable('Users');

        // generate random unique code
        do 
        {
            $numbers = range(0, 9);

            $code = null;

            for ($i = 1; $i <= 5; $i++)
            {
                $code .= $numbers[rand(0, count($numbers) - 1)];
            }

            $code_exists = $verificationsTable->exists(['code' => $code]);

        } while ($code_exists);

        // validate
        $data = $this->request->getData();
        $data['code'] = $code;

        $verification = $verificationsTable->newEmptyEntity();
        $verification = $verificationsTable->patchEntity($verification, $data);

        if ($verification->hasErrors())
        {   
            foreach ($verification->getErrors() as $field => $messages)
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


        // check if email already exsits in users table
        $email_exists = $usersTable->exists([
                                        'email' => $this->request->getData('email')
                                    ]);
                
        if ($email_exists)
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'You are already a member, try logging in instead.'
                                    ]));
        }

        
        // check last sent
       $lastVerification = $verificationsTable->find()
                                                ->where([
                                                    'email' => $this->request->getData('email')
                                                ])
                                                ->orderBy(['EmailVerifications.created' => 'DESC'])
                                                ->first();
        
        if ($lastVerification && time() - $lastVerification->created->getTimestamp() < 60)
        {
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'We have just recently sent you a code.'
                                    ]));
        }


        // save
        if (!$verificationsTable->save($verification)) 
        {   
            return $this->response->withType('application/json')
                                    ->withStringBody(json_encode([
                                        'status'  => 'error',
                                        'message' => 'Failed to update, try again later.'
                                    ]));
        }

        
        // email
        $mailer = new Mailer('default');
        $mailer->setEmailFormat('html')
                ->setFrom(['invoke.jy@gmail.com' => 'JY Store'])
                ->setTo($this->request->getData('email'))
                ->setSubject('JY Store - Emaiil Verification')
                ->setViewVars(['code' => $code])
                ->viewBuilder()
                    ->setTemplate('email')
                    ->setLayout('default');
        $mailer->deliver();

        return $this->response->withType('application/json')
                                ->withStringBody(json_encode([
                                    'status'  => 'success',
                                    'message' => 'A verification code has been sent to your email.'
                                ]));
    }
}
