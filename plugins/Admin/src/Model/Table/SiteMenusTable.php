<?php
namespace Admin\Model\Table;

use Cake\Collection\Collection;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteMenus Model
 *
 * @property \Admin\Model\Table\SiteMenusTable|\Cake\ORM\Association\BelongsTo $ParentSiteMenus
 * @property \Admin\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 * @property \Admin\Model\Table\SiteMenusTable|\Cake\ORM\Association\HasMany $ChildSiteMenus
 *
 * @method \Admin\Model\Entity\SiteMenu get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\SiteMenu newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\SiteMenu[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\SiteMenu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\SiteMenu saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\SiteMenu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\SiteMenu[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\SiteMenu findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SiteMenusTable extends Table
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

        $this->setTable('site_menus');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentSiteMenus', [
            'className' => 'Admin.SiteMenus',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Articles', [
            'foreignKey' => 'site_menu_id',
            'className' => 'Admin.Articles',
            'dependent' => true
        ]);
        $this->hasMany('ChildSiteMenus', [
            'className' => 'Admin.SiteMenus',
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
            ->maxLength('name', 30, '名称超出长度')
            ->requirePresence('name', 'create', '名称不能为空')
            ->allowEmptyString('name', false, '名称不能为空');

        $validator
            ->scalar('subname')
            ->maxLength('subname', 30, '别名超出长度')
            ->allowEmptyString('subname');

        $validator
            ->scalar('pic')
            ->maxLength('pic', 100, '图片超出长度')
            ->allowEmptyString('pic');

        $validator
            ->scalar('content_tpl')
            ->maxLength('content_tpl', 20, '列表模板超出长度')
            ->requirePresence('content_tpl', 'create', '列表模板不能为空')
            ->allowEmptyString('content_tpl', false, '列表模板不能为空');

        $validator
            ->scalar('custom_url')
            ->maxLength('custom_url', 100, '固定链接超出长度')
            ->allowEmptyString('custom_url')
            ->add('custom_url', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => '固定链接重复']);

        $validator
            ->scalar('list_tpl')
            ->maxLength('list_tpl', 20, '内容模板超出长度')
            ->allowEmptyString('list_tpl');

        $validator
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', false, '类型不能为空');

        $validator
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false, '状态不能为空');

        $validator
            ->scalar('link')
            ->maxLength('link', 100, '外链超出长度')
            ->allowEmptyString('link');

        $validator
            ->requirePresence('sort', 'create', '排序不能为空')
            ->allowEmptyString('sort', false, '排序不能为空');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentSiteMenus', '无匹配父类'));
        $rules->add($rules->isUnique(['custom_url'], '固定链接重复'));

        return $rules;
    }


    public function getType()
    {
        return [
            1 => '单页',
            2 => '列表'
        ];
    }


    public function getStatus()
    {
        return [
            1 => '正常',
            2 => '隐藏'
        ];
    }


    /**
     * 查询所有菜单树
     * @param null $not_id
     * @param bool $list 是否列表形式返回
     * @param array $conditions
     * @return array|Collection|\Cake\Collection\CollectionInterface|\Cake\Collection\CollectionTrait
     */
    public function findMenusTree($not_id = null, $list = false, $conditions = [])
    {
        $tree = $this->find()
            ->where($conditions)
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ])
            ->nest('id', 'parent_id');


        if (!empty($not_id)) {

            $tree = $tree->toList();
            $tree = $this->filterTree($tree, $not_id);

            $tree = new Collection($tree);
        }

        $tree = $tree->listNested();
        $newTree = $tree->printer('name', 'id', '&nbsp;&nbsp;&nbsp;&nbsp;|--&nbsp;&nbsp;')->toArray();

        if ($list) {
            return $newTree;
        }

        $data = $tree->each(function ($item) use ($newTree) {
            return $item['name'] = $newTree[$item['id']];
        })->toList();

        return $data;

    }

    /**
     * 菜单树过滤
     * @param array $tree 菜单树
     * @param null $not_id 过滤菜单id及其子菜单
     * @return array
     */
    private function filterTree(array $tree, $not_id = null)
    {

        foreach ($tree as $key => $item) {
            if ($item->id == $not_id) {
                unset($tree[$key]);
                continue;
            }

            if (!empty($item->children)) {
                $item->children = $this->filterTree($item->children, $not_id);
            }
        }

        return $tree;

    }

    /**
     * 通过type获取列表
     * @param null $type
     * @return array
     */
    public function getListByType($type = null)
    {
        $conditions = [];

        if (!empty($type)) {
            $conditions['type'] = $type;
        }

        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where($conditions)
            ->toArray();

    }
}
