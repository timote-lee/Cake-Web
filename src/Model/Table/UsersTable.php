<?php

declare(strict_types=1);

namespace App\Model\Table;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        
        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', [
                'unique' => [
                    'rule'     => 'validateUnique', 
                    'provider' => 'table', 
                    'message'  => 'The email already in use.'
                ]
            ]);

        $validator
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->scalar('password')
            ->minLength('password', 6)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        return $validator;
    }

    public function validationRegister(Validator $validator): Validator
    {
        $validator
            ->maxLength('name', 45)
            ->requirePresence('name')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', [
                'unique' => [
                    'rule'     => 'validateUnique', 
                    'provider' => 'table', 
                    'message'  => 'The email already in use.'
                ]
            ]);

        $validator
            ->requirePresence('verification_code')
            ->notEmptyString('verification_code');

        $validator
            ->scalar('password')
            ->minLength('password', 6)
            ->requirePresence('password')
            ->notEmptyString('password')
            ->add('confirm_password', [
                'confirm' => [
                    'rule'    => ['compareWith', 'password'],
                    'message' => 'The confirm password do not match.'
                ]
            ]);

        return $validator;
    }

    public function validationUpdate(Validator $validator): Validator
    {
        $validator
            ->maxLength('name', 45)
            ->requirePresence('name')
            ->notEmptyString('name');

        return $validator;
    }

    public function validationUpdatePassword(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('current_password')
            ->add('current_password', [
                'match' => [
                    'rule' => function ($value, $context) 
                    {
                        $user = $this->get($context['data']['id']); // Get the user entity

                        if ($user) 
                        {
                            // Check if the provided password matches the stored hash
                            if ((new DefaultPasswordHasher())->check($value, $user->password)) 
                            {
                                return true;
                            }
                        }

                        return false;
                    },
                    'message' => 'The current password is incorrect'
                ]
            ]);

        $validator
            ->scalar('new_password')
            ->minLength('new_password', 6)
            ->notEmptyString('new_password')
            ->add('confirm_new_password', [
                'confirm' => [
                    'rule'    => ['compareWith', 'new_password'],
                    'message' => 'The confirm password do not match.'
                ],
                'not_match' => [
                    'rule' => function ($value, array $context) 
                    {
                        return $value !== $context['data']['current_password'];
                    },
                    'message' => 'New password cannot be the same as the current password.'
                ]
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
