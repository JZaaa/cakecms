<?php
namespace Admin\Model\Table;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
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
            ->maxLength('name', 30, '菜单名称超出长度')
            ->requirePresence('name', 'create', '菜单名称不能为空')
            ->allowEmptyString('name', false, '菜单名称不能为空');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 20, '图标超出长度')
            ->allowEmptyString('icon');

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 20, 'plugin超出长度')
            ->allowEmptyString('plugin');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 20, 'controller超出长度')
            ->allowEmptyString('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 20, 'action超出长度')
            ->allowEmptyString('action');

        $validator
            ->scalar('extend')
            ->maxLength('extend', 20, '拓展参数超出长度')
            ->allowEmptyString('extend');

        $validator
            ->scalar('params')
            ->maxLength('params', 100, '附加参数超出长度')
            ->allowEmptyString('params');

        $validator
            ->scalar('url')
            ->maxLength('url', 100, '链接超出长度')
            ->allowEmptyString('url');

        $validator
            ->requirePresence('sort', 'create')
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
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenus', '无匹配父菜单'));

        return $rules;
    }

    /**
     * 查询所有菜单树
     * @param null $not_id
     * @return array|Collection|\Cake\Collection\CollectionInterface|\Cake\Collection\CollectionTrait
     */
    public function findMenusTree($not_id = null)
    {
        $tree = $this->find()
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

        $data = $tree->each(function ($item) use ($newTree) {
            return $item['name'] = $newTree[$item['id']];
        })->toList();

        return $data;

    }

    /**
     * 获取ztree数据
     * @param array|string $role_id 被选中的id
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function getZtreeData($role_id = [])
    {
        $tree = $this->find()
            ->select([
                'id', 'name', 'parent_id'
            ])
            ->all();

        if (!empty($role_id)) {
            if (is_string($role_id)) {
                $role_id = explode(',', $role_id);
            }
            $tree->each(function ($value) use ($role_id) {
               $value['checked'] = in_array($value->id, $role_id) ? true : false;
            })->toArray();
        }


        return $tree;
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
     * 获取菜单树，两个参数必须设置一个
     * 当$role_id不为空，且$menus_id为空，将会从数据库查询role_id对应菜单id
     * @param null $role_id 用户组id
     * @param bool $collection 聚合功能，返回Menus，与是否为超级权限
     * @return array
     */
    public function getMenus($role_id = null)
    {
        $menus = [];
        $router = [];

        $super = false;


        if (!empty($role_id)) {

            $roleMenu = TableRegistry::getTableLocator()->get('Admin.Roles')->getData(array('Roles.id' => $role_id));

            // 超级管理员权限
            if ($roleMenu['is_super'] != 1) {
                $router = TableRegistry::getTableLocator()->get('Admin.RoleRouters')->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'router'
                ])
                    ->where([
                        'role_id' => $role_id
                    ])
                    ->toList();

                $whiteRouter = Configure::read('whiteRouter');

                $router = array_merge($router, $whiteRouter);

            } else {
                $super = true;
                $router = true;
            }

            // 生成菜单树
            $menus = $this->find()
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ])
                ->reject(function ($item) use ($router) {
                    // 删除隐藏菜单和无权限菜单
                    $return = ($item->is_show != 1);
                    if (is_array($router) && !empty($item['action'])) {
                        $return = ($return || !in_array($item['plugin']. '.' . $item['controller'] . '.' .$item['action'], $router));
                    }
                    return $return;
                })
                ->nest('id', 'parent_id')// 生成树
                ->filter(function ($item) {
//                    // 返回包含根菜单的新数组
                    if ($item->parent_id == 0) {
                        if (empty($item['action']) && empty($item['children'])) {
                            return false;
                        }
                        return true;
                    }
                    return false;
                })
                ->toArray();
        }

        return [
            'menus' => $menus,
            'super' => $super,
            'router' => $router
        ];

    }

    /**
     * 获取根栏目
     * @param array|int $notId
     * @return array
     */
    public function findRoot($notId = [])
    {
        $conditions['parent_id'] = 0;
        if (!empty($notId)) {
            if (is_array($notId)) {
                $conditions['id not in'] = $notId;
            } else {
                $conditions['id <>'] = $notId;
            }
        }
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where($conditions)
            ->toArray();
    }

}
