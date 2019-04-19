<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleRouters Model
 *
 * @property \Admin\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \Admin\Model\Entity\RoleRouter get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\RoleRouter newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\RoleRouter[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\RoleRouter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\RoleRouter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\RoleRouter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\RoleRouter[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\RoleRouter findOrCreate($search, callable $callback = null, $options = [])
 */
class RoleRoutersTable extends Table
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

        $this->setTable('role_routers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->scalar('router')
            ->maxLength('router', 50)
            ->requirePresence('router', 'create')
            ->allowEmptyString('router', false);

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    /**
     * 更新权限表
     * @param $role_id
     * @param array $routers
     * @return bool
     * @throws \Exception
     */
    public function updateRoleRouter($role_id, $routers = [])
    {

        if (!is_array($routers)) {
            $routers = [];
        }

        $data = $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'router'
        ])
            ->where([
                'role_id' => $role_id
            ])
            ->toArray();

        $delete = array_diff($data, $routers);

        $add = array_diff($routers, $data);


        if (!empty($delete)) {
            $this->deleteAll([
                'id in' => array_keys($delete)
            ]);
        }

        if (!empty($add)) {
            $newData = [];

            foreach ($add as $item) {
                $newData[] = [
                    'role_id' => $role_id,
                    'router' => $item
                ];
            }

            $newData = $this->newEntities($newData);

            $this->saveMany($newData);

        }

        return true;

    }
}
