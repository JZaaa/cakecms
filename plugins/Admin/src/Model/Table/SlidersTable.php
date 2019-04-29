<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sliders Model
 *
 * @method \Admin\Model\Entity\Slider get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Slider newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Slider[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Slider|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Slider saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Slider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Slider[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Slider findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SlidersTable extends Table
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

        $this->setTable('sliders');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('tag')
            ->maxLength('tag', 20)
            ->requirePresence('tag', 'create')
            ->allowEmptyString('tag', false);

        $validator
            ->scalar('pic')
            ->maxLength('pic', 100)
            ->requirePresence('pic', 'create')
            ->allowEmptyString('pic', false);

        $validator
            ->scalar('url')
            ->maxLength('url', 100)
            ->allowEmptyString('url');

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('sub')
            ->maxLength('sub', 100)
            ->allowEmptyString('sub');

        $validator
            ->requirePresence('sort', 'create')
            ->allowEmptyString('sort', false);

        return $validator;
    }

    /**
     * 获取轮播图
     * @param string $tag
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function getData($tag = 'home')
    {
        $conditions = [];
        if (!empty($tag)) {
            $conditions['tag'] = $tag;
        }

        return $this->find()
            ->where($conditions)
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ])
            ->all();
    }
}
