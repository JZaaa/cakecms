<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Articles Controller
 *
 * @property \Admin\Model\Table\ArticlesTable $Articles
 *
 * @method \Admin\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    /**
     * 公共数据获取方法
     * @param $type int 类型
     * @param array $conditions
     */
    private function getDataCommon($type, $conditions = [])
    {

        $SiteMenusModel = TableRegistry::getTableLocator()->get('Admin.SiteMenus');
        $typeArray = $SiteMenusModel->getType();

        if (!isset($typeArray[$type])) {
            throw new NotFoundException('不存在的栏目类型');
        }

        $siteMenus = $SiteMenusModel->getListByType($type);

        if (!empty($title = $this->request->getQuery('title'))) {
            $conditions['Articles.title like'] = '%' . $title . '%';
        }

        if (!empty($siteMenu = $this->request->getQuery('site_menu'))) {
            $conditions['Articles.site_menu_id'] = $siteMenu;
        } else {
            if (!empty(array_keys($siteMenus))) {
                $conditions['Articles.site_menu_id in'] = array_keys($siteMenus);
            } else {
                // 空则代表无
                $conditions['Articles.id'] = 0;
            }
        }

        $query = $this->Articles->find()
            ->contain([
                'SiteMenus' => [
                    'fields' => [
                        'id', 'name', 'type'
                    ]
                ]
            ])
            ->where($conditions)
            ->order([
                'Articles.istop' => 'asc',
                'Articles.id' => 'desc'
            ]);

        $data = $this->paginate($query);

        $this->set(compact('data', 'title', 'siteMenus', 'siteMenu', 'type'));

    }

    /**
     * @param $type int 类型, 当前 1: 单页， 2：列表
     *
     */
    public function index($type = 1)
    {
        if (!is_numeric($type)) {
            $type = 1;
        }
        $this->getDataCommon($type);
    }


    /**
     * 新增
     * @return \App\Controller\AppController
     */
    public function add()
    {
        $type = $this->request->getQuery('type');

        $this->CURL = Router::url(['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'index', $type], true);


        if ($this->request->is('post')) {
            $data = $this->Articles->newEntity();

            $newData = $this->request->getData();

            $menus = TableRegistry::getTableLocator()->get('Admin.SiteMenus')->get($newData['site_menu_id'], [
                'fields' => [
                    'id', 'type'
                ]
            ]);

            if ($menus['type'] == 1) {
                return $this->jsonResponse([
                   'code' => 300,
                   'message' => '该栏目不允许新增'
                ]);
            }


            $data = $this->Articles->patchEntity($data, $newData);

            if ($this->Articles->save($data)) {
                return $this->jsonResponse([
                    'code' => 200,
                    'refresh' => false,
                    'redirect' => $this->CURL
                ]);
            }

            return $this->getError($data);
        }


        $siteMenus = TableRegistry::getTableLocator()->get('Admin.SiteMenus')->findMenusTree(null, true, [
            'type' => $type
        ]);


        if (empty($siteMenus)) {
            throw new NotFoundException('请添加对应栏目后再进行操作！');
        }

        $this->set(compact('siteMenus', 'type'));

    }

    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $type = $this->request->getQuery('type');

        $this->CURL = Router::url(['plugin' => 'Admin', 'controller' => 'Articles', 'action' => 'index', $type], true);

        $data = $this->Articles->get($id, [
            'contain' => [
                'SiteMenus' => [
                    'fields' => [
                        'id', 'type'
                    ]
                ]
            ]
        ]);


        if ($this->request->is('post')) {

            $newData = $this->request->getData();

            // 单页不允许更改所属栏目
            if ($data['site_menu']['type'] == 1) {
                unset($newData['site_menu_id']);
            }

            // 删除关联
            unset($data['site_menu']);

            $data = $this->Articles->patchEntity($data, $newData);

            if ($this->Articles->save($data)) {
                return $this->jsonResponse([
                    'code' => 200,
                    'refresh' => false,
                    'redirect' => $this->CURL
                ]);
            }

            return $this->getError($data);
        }


        $siteMenus = TableRegistry::getTableLocator()->get('Admin.SiteMenus')->findMenusTree(null, true, [
            'type' => $type
        ]);


        if (empty($siteMenus)) {
            throw new NotFoundException('请添加对应栏目后再进行操作！');
        }

        $this->set(compact('id', 'data', 'type', 'siteMenus'));
    }


    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->Articles->get($id, [
                'contain' => [
                    'SiteMenus' => [
                        'fields' => [
                            'id', 'type'
                        ]
                    ]
                ]
            ]);

            if ($data['site_menu']['type'] == 1) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '该栏目文章不允许删除'
                ]);
            }

            unset($data['site_menu']);

            if ($this->Articles->delete($data)) {
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300);
    }
}
