<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Exception\InternalErrorException;
use ReflectionClass;
use ReflectionMethod;

/**
 * Routers Controller
 *
 * 路由表
 * @property \Admin\Model\Table\RoutersTable $Routers
 *
 * @method \Admin\Model\Entity\Router[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoutersController extends AppController
{

    /**
     * 路由管理
     */
    public function index()
    {
        $data = $this->Routers->find()
            ->order([
                'Routers.sort' => 'desc',
                'Routers.id' => 'desc'
            ])
            ->nest('id', 'parent_id');

        $data = $data->listNested()->toList();

        $this->set(compact('data'));
    }

    /**
     * 新增
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $newData = $this->request->getData();

            if (!empty($newData['parent_id'])) {
                $parent = $this->Routers->get($newData['parent_id'], [
                    'fields' => [
                        'id', 'level'
                    ]
                ]);

                $newData['level'] = $parent['level'] + 1;
            } else {
                $newData['level'] = 1;
            }

            if (!empty($newData['init']) && $newData['level'] == 3) {
                return $this->initRouter($newData);

            } else {
                $data = $this->Routers->newEntity();
                $data = $this->Routers->patchEntity($data, $newData);

                if ($this->Routers->save($data)) {
                    return $this->jsonResponse(200);
                }
            }

            return $this->getError($data);
        }

        $this->ajaxView();

        $parents = $this->Routers->getRouterList();

        $this->set(compact('parents'));

    }

    /**
     * 生成路由脚手架
     * @param $data
     * @return \App\Controller\AppController
     */
    private function initRouter($data)
    {
        $array = [
            [
                'router' => 'index',
                'name' => '浏览',
                'sort' => 90
            ],
            [
                'router' => 'add',
                'name' => '新增',
                'sort' => 80
            ],
            [
                'router' => 'edit',
                'name' => '编辑',
                'sort' => 70
            ],
            [
                'router' => 'delete',
                'name' => '删除',
                'sort' => 60
            ]
        ];

        $newData = [];

        foreach ($array as $item) {
            $item['parent_id'] = $data['parent_id'];
            $item['level'] = 3;
            $item['router'] = $data['router'] . '.' . $item['router'];
            $newData[] = $item;
        }

        $newData = $this->Routers->newEntities($newData);

        try {
            $res = $this->Routers->saveMany($newData);
        } catch (\Exception $e) {
            $res = false;
        }

        return $res ? $this->jsonResponse(200) : $this->jsonResponse(300);
    }


    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->Routers->get($id);

        if ($this->request->is('post')) {
            $newData = $this->request->getData();

            $data = $this->Routers->patchEntity($data, $newData);

            if ($data->isDirty('parent_id')) {
                if (!empty($newData['parent_id'])) {
                    $parent = $this->Routers->get($newData['parent_id'], [
                        'fields' => [
                            'id', 'level'
                        ]
                    ]);

                    $data['level'] = $parent['level'] + 1;
                } else {
                    $data['level'] = 1;
                    $data['parent_id'] = 0;
                }
            }


            if ($this->Routers->save($data)) {
                return $this->jsonResponse(200);
            }

            return $this->getError($data);
        }

        $this->ajaxView();
        $parents = $this->Routers->getRouterList();

        $this->set(compact('id', 'data', 'parents'));

    }


    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->Routers->get($id);

            if ($this->Routers->delete($data)) {
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300);
    }

    /**
     * 重新生成路由
     * @deprecated 现在手动维护路由表
     * @return \App\Controller\AppController
     */
    private function reset()
    {
        $sql = $this->Routers->getSchema()->truncateSql($this->Routers->getConnection());

        foreach ($sql as $item) {
            $this->Routers->getConnection()->execute($item)->execute();
        }

        return $this->load();

    }

    /**
     * 生成路由
     * 仅增加新路由，原路由需要自己维护
     * @deprecated 现在手动维护路由表
     * @return \App\Controller\AppController
     */
    private function load()
    {

        $pluginName = 'Admin'; // 生成Admin路由

        $routers = $this->Routers->find()
            ->select([
                'id', 'level', 'router'
            ])
            ->all()
            ->groupBy('level')
            ->toArray();

        $collection = [
            1 => [], // level 1 plugin集合
            2 => [], // level 2 controller集合
            3 => [] // level 3 action集合
        ];

        // 格式化
        foreach ($collection as $key => $item) {
            if (isset($routers[$key])) {
                $collection[$key] = (new Collection($routers[$key]))
                    ->indexBy('router')
                    ->toArray();
            }
        }

        // 无plugin则插件下所有都新建
        if (!array_key_exists($pluginName, $collection[1])) {
            $data = $this->Routers->newEntity();
            $data = $this->Routers->patchEntity($data, [
                'level' => 1,
                'router' => $pluginName,
                'sort' => 0
            ]);
            $data = $this->Routers->saveOrFail($data);

            $parent_id = $data->id;

        } else {
            $parent_id = $collection[1][$pluginName]['id'];
        }

        $data = [];
        $controller = $this->getControllers($pluginName);

        $action = [];

        foreach ($controller as $item) {
            if (!array_key_exists($item, $collection[2])) {
                $data[] = [
                    'level' => 2,
                    'router' => $item,
                    'sort' => 0,
                    'parent_id' => $parent_id
                ];
            }

            $action = array_merge($action, $this->getActions($pluginName, $item));

        }

        if (!empty($data)) {
            $data = $this->Routers->newEntities($data);

            try {
                $data = $this->Routers->saveMany($data);
            } catch (\Exception $e) {
                throw new InternalErrorException($e->getMessage());
            }

            $collection[2] = (new Collection($data))->indexBy('router')->toArray();

        }


        $data = [];

        foreach ($action as $key => $item) {
            $parent_id = $collection[2][$key]['id'];

            foreach ($item as $value) {
                if (!array_key_exists($value, $collection[3])) {
                    $data[] = [
                        'level' => 3,
                        'router' => $value,
                        'sort' => 0,
                        'parent_id' => $parent_id
                    ];
                }
            }
        }

        if (!empty($data)) {
            $data = $this->Routers->newEntities($data);

            try {
                $this->Routers->saveMany($data);
            } catch (\Exception $e) {
                throw new InternalErrorException($e->getMessage());
            }
        }

        return $this->jsonResponse(200);

    }

    /**
     * 获取Controllers
     * @param string $plugin 插件名称
     * @return array
     */
    private function getControllers($plugin) {
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php'
        ];

        $files = scandir(ROOT . '/plugins/' . $plugin . '/src/Controller/');

        $results = [];
        foreach($files as $file){
            if(!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }

        return $results;
    }

    /**
     * 获取actions
     * @param $plugin
     * @param $controllerName
     * @return array
     */
    private function getActions($plugin, $controllerName) {
        $className = $plugin . '\\Controller\\'.$controllerName.'Controller';
        try {
            $class = new ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new InternalErrorException($e->getMessage());
        }
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];

        $actionIgnore = Configure::read('routerIgnore.action');


        foreach($actions as $action){
            if($action->class == $className && !in_array($action->name, $ignoreList)){
//                $results[] = Router::normalize(['plugin' => $plugin, 'controller' => $controllerName, 'action' => $action->name]);
//                $results[$controllerName][] = $action->name;
                $router = $plugin . '.' . $controllerName . '.' . $action->name;
                if (!in_array($router, $actionIgnore)) {
                    $results[$controllerName][] = $router;
                }
            }
        }
        return $results;
    }

    /**
     * 集合
     * @param $plugin string 插件名称
     * @return array
     */
    private function getResources($plugin){

        $controllers = $this->getControllers($plugin);
        $resources = [];
        foreach($controllers as $controller){
            $actions = $this->getActions($plugin, $controller);
            $resources = array_merge($resources, $actions);
        }
        return [
            $plugin => $resources
        ];
    }
}
