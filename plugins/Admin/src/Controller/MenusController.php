<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \Admin\Model\Table\MenusTable $Menus
 *
 * @method \Admin\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{

    /**
     * 菜单列表
     */
    public function index()
    {
        $data = $this->Menus->findMenusTree();

        $this->set(compact('data'));

    }


    /**
     * 添加
     * @return \App\Controller\AppController
     */
    public function add()
    {
        if ($this->request->is('post')) {

            $entity = $this->Menus->newEntity();
            $data = $this->request->getData();

            foreach ($data as $key => $item) {
                if (trim($item) == '') {
                    $data[$key] = null;
                }
            }

            $data = $this->Menus->patchEntity($entity, $data);

            if ($this->Menus->save($data)) {
                return $this->jsonResponse(200);
            } else {
                return $this->getError($data);
            }

        }

        $this->ajaxView();
        $parents = $this->Menus->findRoot();

        $this->set(compact('parents'));

    }

    public function edit($id = null)
    {
        $data = $this->Menus->find()
            ->where([
                'id' => $id
            ])
            ->first();
        if ($this->request->is('post')) {
            if ($data->is_root == 1) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '当前菜单不允许修改'
                ]);
            }

            $newData = $this->request->getData();

            foreach ($newData as $key => $item) {
                if (trim($item) == '') {
                    $newData[$key] = null;
                }
            }

            $newData = $this->Menus->patchEntity($data, $newData);

            if ($this->Menus->save($newData)) {
                return $this->jsonResponse(200);
            } else {
                return $this->getError($newData);
            }

        }
        $this->ajaxView();
        $parents = $this->Menus->findRoot($id);

        $this->set(compact('parents', 'id', 'data'));

    }


    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        if ($this->request->is('post')) {

            $data = $this->Menus->find()
                ->contain([
                    'ChildMenus' => function($q) {
                        return $q->limit(1);
                    }
                ])
                ->where([
                    'id' => $id
                ])
                ->first();

            if ($data['is_root'] == 1) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '该菜单不可删除！'
                ]);
            }

            if (!empty($data) && !empty($data->child_menus)) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '请先删除子类菜单'
                ]);
            }

            unset($data['child_menus']);

            if ($this->Menus->delete($data)) {
                return $this->jsonResponse(200);
            }

        }

        return $this->jsonResponse(300, false);

    }

}
