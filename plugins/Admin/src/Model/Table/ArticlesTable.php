<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 *
 * @property \Admin\Model\Table\SiteMenusTable|\Cake\ORM\Association\BelongsTo $SiteMenus
 *
 * @method \Admin\Model\Entity\Article get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Article saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Article findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArticlesTable extends Table
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

        $this->setTable('articles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SiteMenus', [
            'foreignKey' => 'site_menu_id',
            'joinType' => 'INNER',
            'className' => 'Admin.SiteMenus'
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
            ->scalar('title')
            ->maxLength('title', 50, '标题超出长度')
            ->requirePresence('title', 'create', '标题不能为空')
            ->allowEmptyString('title', false, '标题不能为空');

        $validator
            ->scalar('color')
            ->maxLength('color', 10, '颜色值超出长度')
            ->allowEmptyString('color');

        $validator
            ->scalar('subtitle')
            ->maxLength('subtitle', 100, '副标题超出长度')
            ->allowEmptyString('subtitle');

        $validator
            ->scalar('author')
            ->maxLength('author', 30, '作者超出长度')
            ->allowEmptyString('author');

        $validator
            ->scalar('source')
            ->maxLength('source', 30, '来源超出长度')
            ->allowEmptyString('source');

        $validator
            ->dateTime('date')
            ->allowEmptyDateTime('date');

        $validator
            ->scalar('thumb')
            ->maxLength('thumb', 100, '缩略图超出长度')
            ->allowEmptyString('thumb');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->scalar('seo_keywords')
            ->maxLength('seo_keywords', 100, 'seo关键字超出长度')
            ->allowEmptyString('seo_keywords');

        $validator
            ->scalar('seo_description')
            ->maxLength('seo_description', 200, 'seo描述超出长度')
            ->allowEmptyString('seo_description');

        $validator
            ->requirePresence('status', 'create', '状态不能为空')
            ->allowEmptyString('status', false, '状态不能为空');

        $validator
            ->requirePresence('istop', 'create', '置顶不能为空')
            ->allowEmptyString('istop', false, '置顶不能为空');

        $validator
            ->nonNegativeInteger('visit')
            ->allowEmptyString('visit');

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
        $rules->add($rules->existsIn(['site_menu_id'], 'SiteMenus'));

        return $rules;
    }

    /**
     * 创建文章
     * @param $site_menu_id
     * @param $title
     * @return \Admin\Model\Entity\Article|bool
     */
    public function createItem($site_menu_id, $title)
    {
        $data = $this->newEntity();
        $newData = [
            'site_menu_id' => $site_menu_id,
            'title' => empty($title) ? '单页' : $title,
            'visit' => 0,
            'istop' => 2,
            'status' => 1,
            'date' => date('Y-m-d H:i:s')
        ];

        $data = $this->patchEntity($data, $newData);

        return $this->save($data);

    }
}
