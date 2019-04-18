<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Admin\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \Admin\Model\Entity\User get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Roles'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 30, '用户名超出长度')
            ->requirePresence('username', 'create', '用户名不能为空')
            ->allowEmptyString('username', false, '用户名不能为空')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => '用户名重复']);

        $validator
            ->scalar('password')
            ->maxLength('password', 100, '密码超出长度')
            ->requirePresence('password', 'create', '密码不能为空')
            ->allowEmptyString('password', false, '密码不能为空');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 30, '昵称超出长度')
            ->requirePresence('nickname', 'create', '昵称不能为空')
            ->allowEmptyString('nickname', false, '昵称不能为空');

        $validator
            ->requirePresence('status', 'create', '用户状态不能为空')
            ->allowEmptyString('status', false, '用户状态不能为空');

        $validator
            ->nonNegativeInteger('login_count')
            ->requirePresence('login_count', 'create', '登录次数不能为空')
            ->allowEmptyString('login_count', false, '登录次数不能为空');

        $validator
            ->scalar('login_ip')
            ->maxLength('login_ip', 11)
            ->allowEmptyString('login_ip');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }


    public function getStatus()
    {
        return [
            1 => '正常',
            2 => '冻结'
        ];
    }
}
