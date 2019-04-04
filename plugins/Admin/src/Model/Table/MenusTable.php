<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \Admin\Model\Table\MenusTable|\Cake\ORM\Association\BelongsTo $ParentMenus
 * @property \Admin\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $ChildMenus
 *
 * @method \Admin\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Menu newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Menu saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Menu findOrCreate($search, callable $callback = null, $options = [])
 */
class MenusTable extends Table
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

        $this->setTable('menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentMenus', [
            'className' => 'Admin.Menus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenus', [
            'className' => 'Admin.Menus',
            'foreignKey' => 'parent_id'
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
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 20)
            ->allowEmptyString('plugin');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 20)
            ->requirePresence('controller', 'create')
            ->allowEmptyString('controller', false);

        $validator
            ->scalar('action')
            ->maxLength('action', 20)
            ->requirePresence('action', 'create')
            ->allowEmptyString('action', false);

        $validator
            ->scalar('params')
            ->maxLength('params', 100)
            ->allowEmptyString('params');

        $validator
            ->scalar('url')
            ->maxLength('url', 100)
            ->allowEmptyString('url');

        $validator
            ->requirePresence('sort', 'create')
            ->allowEmptyString('sort', false);

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus'));

        return $rules;
    }
}
