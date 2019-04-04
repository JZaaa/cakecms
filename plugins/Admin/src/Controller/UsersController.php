<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

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

        if ($this->Auth->user()) {
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
}
