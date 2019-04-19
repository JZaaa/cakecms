<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Roles Controller
 *
 * @property \Admin\Model\Table\RolesTable $Roles
 *
 * @method \Admin\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{


    public function index()
    {
        $this->setPage();

        $conditions = [];

        if (!empty($name = $this->request->getQuery('name'))) {
            $conditions['name'] = $name;
        }

        $query = $this->Roles->find()
            ->where($conditions);

        $data = $this->paginate($query);

        $this->set(compact('data', 'name'));
    }

    /**
     * 新增
     * @return \App\Controller\AppController
     */
    public function add()
    {
        $url = Router::url(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'index'], true);

        if ($this->request->is('post')) {
            $data = $this->Roles->newEntity();
            $newData = $this->request->getData();

            $newData['is_super'] = 2;
            $data = $this->Roles->patchEntity($data, $newData, [
                'fields' => [
                    'name', 'description', 'is_super'
                ]
            ]);

            if ($res = $this->Roles->save($data)) {
                TableRegistry::getTableLocator()->get('Admin.RoleRouters')->updateRoleRouter($res['id'], $this->request->getData('role_router'));
                return $this->jsonResponse([
                    'code' => 200,
                    'refresh' => false,
                    'redirect' => $url
                ]);
            }
            return $this->getError($data);
        }

        $this->CURL = $url;
        $routers = TableRegistry::getTableLocator()->get('Admin.Routers')->getAllTree();


        $this->set(compact('routers'));
    }


    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->Roles->get($id);

        $url = Router::url(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'index'], true);

        if ($this->request->is('post')) {
            $newData = $this->request->getData();
            TableRegistry::getTableLocator()->get('Admin.RoleRouters')->updateRoleRouter($id, $this->request->getData('role_router'));


            $data = $this->Roles->patchEntity($data, $newData, [
                'fields' => [
                    'name', 'description'
                ]
            ]);

            if ($this->Roles->save($data)) {
                return $this->jsonResponse([
                    'code' => 200,
                    'refresh' => false,
                    'redirect' => $url
                ]);
            }

            return $this->getError($data);
        }

        $this->CURL = $url;

        $routers = TableRegistry::getTableLocator()->get('Admin.Routers')->getAllTree();

        $roles = TableRegistry::getTableLocator()->get('Admin.RoleRouters')->find('list', [
            'keyField' => 'router',
            'valueField' => 'id'
        ])->toArray();


        $this->set(compact('id', 'data', 'roles', 'routers'));
    }

    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->Roles->get($id);

            if ($data['is_super'] == 1) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '超级权限角色无法删除！'
                ]);
            }

            if ($this->Roles->delete($data)) {
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300);
    }


}
