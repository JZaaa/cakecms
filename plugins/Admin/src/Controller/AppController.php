<?php

namespace Admin\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

class AppController extends BaseController
{

    public $USER;
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
        $this->USER = $this->Auth->user();

        $this->checkAuth();

        $this->viewBuilder()->setLayout('admin');
    }

    /**
     * 页面渲染之前处理
     * @param Event $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeRender(Event $event)
    {
        $this->set('USERNAME', $this->USER['username']);
        $this->set('SUPER', $this->USER['is_super']);
        // 若为普通后台页面，则获取页面菜单
        if ($this->viewBuilder()->getLayout() == 'admin') {
            $this->getMenusTree();
        }
    }

    /**
     * 获取页面菜单
     * 修改权限时需重新登录
     */
    private function getMenusTree()
    {
        $MENUS =$this->USER['menus'];

        $this->set(compact('MENUS'));
    }

    /**
     * 权限验证，不通过抛出403错误
     */
    private function checkAuth()
    {
        if (!empty($this->USER)) {
            $router = $this->USER['router'];
            $params = $this->request->getAttributes()['params'];

            if (!$this->USER['is_super'] && !in_array($params['plugin'] . '.' . $params['controller'] . '.' . $params['action'], $router)) {
                throw new UnauthorizedException('无权限访问', 403);
            }
        }

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
     * @param bool $close 是否关闭弹窗
     * @return BaseController
     */
    public function jsonResponse($code = 200, $refresh = true, $data = [], $message = null, $redirect = false, $timeout = 1000, $close = true)
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
            'timeout' => $timeout,
            'closeDialog' => $close
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


    /**
     * @param int $numPerPage
     */
    public function setPage($numPerPage = 20)
    {
        $page = !empty($this->request->getData('page')) ? $this->request->getData('page') : (!empty($this->request->getQuery('page')) ? $this->request->getQuery('page') : 1);

        $this->paginate['page'] = $page;
        $this->paginate['limit'] = $numPerPage;

        $this->set(compact('page', 'numPerPage'));

    }
}
