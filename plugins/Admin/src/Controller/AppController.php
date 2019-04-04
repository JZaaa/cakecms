<?php

namespace Admin\Controller;

use App\Controller\AppController as BaseController;
use Cake\Http\Exception\InternalErrorException;

class AppController extends BaseController
{

    public function initialize()
    {
        parent::initialize();

        try {
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'userModel' => 'Admin.Users'
                    ]
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'login',
                    'plugin' => 'Admin'
                ],
                'loginRedirect' => [
                    'controller' => 'Home',
                    'action' => 'index',
                    'plugin' => 'Admin'
                ],
                'authError' => false,
                'storage' => [
                    'className' => 'Session',
                    'key' => 'Admin.User'
                ]
            ]);
        } catch (\Exception $e) {
            throw new InternalErrorException($e->getMessage());
        }

        $this->set('username', $this->Auth->user('username'));
        $this->viewBuilder()->setLayout('admin');
    }


    public function ajaxView()
    {
        $this->viewBuilder()->setLayout('ajax');
    }
}
