<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Options Model
 *
 * @method \Admin\Model\Entity\Option get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Option newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Option[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Option|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Option saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Option patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Option[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Option findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionsTable extends Table
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

        $this->setTable('options');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('key_field')
            ->maxLength('key_field', 30)
            ->requirePresence('key_field', 'create')
            ->allowEmptyString('key_field', false);

        $validator
            ->scalar('value_field')
            ->allowEmptyString('value_field');

        $validator
            ->scalar('tag')
            ->maxLength('tag', 20)
            ->requirePresence('tag', 'create')
            ->allowEmptyString('tag', false);

        return $validator;
    }
}
