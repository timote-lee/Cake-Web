<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailVerifications Model
 *
 * @method \App\Model\Entity\EmailVerification newEmptyEntity()
 * @method \App\Model\Entity\EmailVerification newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EmailVerification> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailVerification get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EmailVerification findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EmailVerification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EmailVerification> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailVerification|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EmailVerification saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EmailVerification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmailVerification>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmailVerification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmailVerification> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmailVerification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmailVerification>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EmailVerification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EmailVerification> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailVerificationsTable extends Table
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

        $this->setTable('email_verifications');
        $this->setDisplayField('email');
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
            ->notEmptyString('email');

        $validator
            ->scalar('code')
            ->maxLength('code', 15)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->dateTime('used')
            ->allowEmptyDateTime('used');

        return $validator;
    }
}
