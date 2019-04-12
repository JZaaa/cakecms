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


    /**
     * 独立视图，一般用于弹出页面
     */
    public function ajaxView()
    {
        $this->viewBuilder()->setLayout('ajax');
    }


    /**
     * json 返回
     * @param int|array $code|$options 返回Code,若传递为数组,则代表配置项
     * @param bool $refresh 是否刷新页面
     * @param array $data 返回数据
     * @param null $message 错误提示
     * @param false|string $redirect 跳转链接, 这里的跳转配合timeout用于前端提示等操作
     * @param int $timeout 跳转等待时间
     * @return BaseController
     */
    public function jsonResponse($code = 200, $refresh = true, $data = [], $message = null, $redirect = false, $timeout = 1000)
    {
        if (is_array($code)) {
            foreach ($code as $key => $value) {
                $$key = $value;
            }
        }

        if (empty($message)) {
            switch ($code) {
                case 200:
                    $message = '操作成功';
                    break;
                case 300:
                    $message = '操作失败';
                    break;
                case 403:
                    $message = '无权限访问';
                    break;
                default:
                    $message = '未知错误';
            }
        }
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'refresh' => $refresh,
            'redirect' => $redirect,
            'timeout' => $timeout
        ];
        return parent::apiResponse($data);
    }

    /**
     * 返回错误提示
     * 调用必须return
     * @param $entity object 数据实体
     * @param $jump bool 是否自动跳转, 否则返回错误信息
     * @return BaseController
     */
    public function getError($entity, $jump = true)
    {
        try{
            $message = current(current($entity->getErrors()));
        } catch (\Exception $e) {
            $message = null;
        }

        return $jump ? $this->jsonResponse([
            'message' => '操作失败！' . $message,
            'code' => 300
        ]) : $message;
    }
}
