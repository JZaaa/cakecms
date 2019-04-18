<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \Admin\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \Admin\Model\Entity\Role get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Role|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 */
class RolesTable extends Table
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

        $this->setTable('roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'role_id',
            'className' => 'Admin.Users',
            'dependent' => true
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
            ->scalar('name')
            ->maxLength('name', 30, '名称超出长度')
            ->requirePresence('name', 'create', '名称不能为空')
            ->allowEmptyString('name', false, '名称不能为空');

        $validator
            ->scalar('description')
            ->maxLength('description', 50, '描述超出长度')
            ->allowEmptyString('description');

        $validator
            ->requirePresence('is_super', 'create')
            ->allowEmptyString('is_super');

        $validator
            ->scalar('role_menu')
            ->allowEmptyString('role_menu');

        $validator
            ->scalar('role_auth')
            ->allowEmptyString('role_auth');

        return $validator;
    }


    /*
     * 获取数据详情
     *
     * */
    public function getData($conditions = []) {
        $query = $this->find('all')
            ->where($conditions);
        return $query->first();
    }

    /**
     * 返回角色列表
     * @param bool $show_super 是否显示超级权限
     * @return array
     */
    public function getList($show_super = false)
    {
        $conditions = [];

        if (!$show_super) {
            $conditions['is_super'] = 2;
        }
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where($conditions)
            ->toArray();

    }
}
