<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \Admin\Model\Table\UsersTable $Users
 *
 * @method \Admin\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login']);
    }

    /**
     * 登录
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if (!empty($this->request->getData())) {
                $tip = '用户名或密码错误';
                $user = $this->Auth->identify();
                if ($user && $user['status'] == 1) {
                    // menus写入
                    $menus = TableRegistry::getTableLocator()->get('Admin.Menus')->getMenus($user['role_id'], true);

                    $data = $this->Users->get($user['id']);
                    $data = $this->Users->patchEntity($data, [
                        'id' => $user['id'],
                        'login_ip' => $this->request->clientIp(),
                        'login_count' => $user['login_count'] + 1
                    ]);
                    $this->Users->save($data);

                    $user['menus'] = $menus['menus'];
                    $user['is_super'] = $menus['super'];
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                if ($user && $user['status'] == 2) {
                    $tip = '您已被禁止登录，如有疑问，请联系管理员！';
                }
                $this->Flash->error($tip, ['key' => 'tip']);
                $username = $this->request->getData('username');
                $password = $this->request->getData('password');

                $this->set(compact('username', 'password'));
            }

        }

        if ($this->USER) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->ajaxView();

    }


    /**
     * 退出登录
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    /**
     * 系统用户
     */
    public function index()
    {
        $this->setPage();

        $conditions = [];

        if (!empty($username = $this->request->getQuery('username'))) {
            $conditions['username'] = $username;
        }

        $query = $this->Users->find()
            ->contain([
                'Roles' => [
                    'fields' => [
                        'id', 'name', 'is_super'
                    ]
                ]
            ])
            ->selectAllExcept($this->Users, ['password', 'created', 'modified'])
            ->where($conditions)
            ->order([
                'Users.id' => 'desc'
            ]);

        $data = $this->paginate($query);


        $this->set(compact('data', 'username'));
    }

    /**
     * 新增
     * @return \App\Controller\AppController
     */
    public function add()
    {

        if ($this->request->is('post')) {
            $data = $this->Users->newEntity();
            $newData = $this->request->getData();
            $newData['login_count'] = 0;
            $data = $this->Users->patchEntity($data, $newData);


            if ($this->Users->save($data)) {
                return $this->jsonResponse(200);
            }

            return $this->getError($data);
        }

        $super = $this->USER['is_super'];

        $roles = TableRegistry::getTableLocator()->get('Admin.Roles')->getList($super);

        $status = $this->Users->getStatus();

        $this->ajaxView();
        $this->set(compact('id', 'roles', 'status', 'data'));
    }

    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->Users->get($id);

        if ($this->request->is('post')) {

            $newData = $this->request->getData();

            $data = $this->Users->patchEntity($data, $newData, [
                'fields' => [
                    'username', 'nickname', 'status'
                ]
            ]);

            if ($this->Users->save($data)) {
                return $this->jsonResponse(200);
            }

            return $this->getError($data);
        }

        $super = $this->USER['is_super'];
        $roles = TableRegistry::getTableLocator()->get('Admin.Roles')->getList($super);

        $status = $this->Users->getStatus();

        $this->ajaxView();
        $this->set(compact('id', 'roles', 'status', 'data'));
    }

    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->Users->get($id);

            $role = TableRegistry::getTableLocator()->get('Admin.Roles')->get($data['role_id'], [
                'fields' => [
                    'id', 'is_super'
                ]
            ]);

            if ($role['is_super'] == 1) {
                return $this->jsonResponse([
                    'code' => 300,
                    'message' => '超级权限用户，无法删除！'
                ]);
            }

            if ($this->Users->delete($data)) {
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300);
    }



}
