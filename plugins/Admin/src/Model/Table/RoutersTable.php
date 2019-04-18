<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Routers Model
 *
 * @property \Admin\Model\Table\RoutersTable|\Cake\ORM\Association\BelongsTo $ParentRouters
 * @property \Admin\Model\Table\RoutersTable|\Cake\ORM\Association\HasMany $ChildRouters
 *
 * @method \Admin\Model\Entity\Router get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Router newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Router[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Router|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Router saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Router patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Router[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Router findOrCreate($search, callable $callback = null, $options = [])
 */
class RoutersTable extends Table
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

        $this->setTable('routers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentRouters', [
            'className' => 'Admin.Routers',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildRouters', [
            'className' => 'Admin.Routers',
            'foreignKey' => 'parent_id',
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
            ->maxLength('name', 20)
            ->allowEmptyString('name');

        $validator
            ->scalar('router')
            ->maxLength('router', 50)
            ->requirePresence('router', 'create')
            ->allowEmptyString('router', false);

        $validator
            ->requirePresence('level', 'create')
            ->allowEmptyString('level', false);

        $validator
            ->requirePresence('sort', 'create')
            ->allowEmptyString('sort', false);

        return $validator;
    }


    /**
     * 获取1，2级路由
     * @param $conditions
     * @return mixed
     */
    public function getRouterList()
    {
        return $this->find()
            ->select([
                'id', 'router', 'parent_id'
            ])
            ->where([
                'level in' => [1, 2]
            ])
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ])
            ->nest('id', 'parent_id')
            ->listNested()
            ->printer('router', 'id', '&nbsp;&nbsp;&nbsp;&nbsp;|--&nbsp;&nbsp;')
            ->toArray();
    }

    /**
     * 获取所有router树
     * @return array
     */
    public function getAllTree()
    {
        return $this->find()
            ->select([
                'id', 'router', 'name', 'parent_id'
            ])
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ])
            ->nest('id', 'parent_id')
            ->toArray();
    }
}
