<?php

namespace Website\Controller;

use App\Controller\AppController as BaseController;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class AppController extends BaseController
{

    public $ACTIVE_MENU = ''; // 当前页面所属根栏目url
    public $ACTIVE_NAV = ''; // 当前页面所属栏目url
    public $SITE_MENU = null; // 栏目缓存
    public $ACTIVE_NAV_ID = null; // 当前页面所属栏目id,用于手动指定栏目

    private $CacheKey = 'site';

    public function initialize()
    {
        parent::initialize();

        $this->ACTIVE_NAV = rtrim($this->request->getAttribute('here'), '/');
        $this->SITE_MENU = $this->getMenusCache();

    }

    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setLayout('website');

        $breadcrumbs = $this->getBreadcrumbs();


        /**
         * 公共变量
         * _ActiveMenu_ =>  当前页面所属根栏目url
         * _ActiveNav_ =>  当前页面所属栏目url
         * _CurrentMenu_ =>  当前页面根导航信息
         * _SiteMenus_ =>  顶部导航
         * _Breadcrumbs_ =>  当前页面路径(面包屑)
         */
        $this->set([
            '_ActiveMenu_' => isset($breadcrumbs[1]) ? $breadcrumbs[1]['url'] : $this->ACTIVE_NAV,
            '_ActiveNav_' => $this->ACTIVE_NAV,
            '_CurrentMenu_' => isset($breadcrumbs[1]) ? $breadcrumbs[1] : null,
            '_SiteMenus_' => $this->SITE_MENU['tree'],
            '_Breadcrumbs_' => $breadcrumbs
        ]);
    }

    /**
     * 获取面包屑
     * @return array
     */
    public function getBreadcrumbs()
    {
        $siteMenus = $this->SITE_MENU['menus'];

        $data[] = $this->getHome();

        if (is_numeric($this->ACTIVE_NAV_ID) && isset($siteMenus[$this->ACTIVE_NAV_ID])) {
            $this->ACTIVE_NAV = $siteMenus[$this->ACTIVE_NAV_ID]['url'];
        }

        foreach ($siteMenus as $item) {
            if ($item['url'] == $this->ACTIVE_NAV) {
                $parent = $this->getMenuParentById($item['id']);
                $data[] = $parent;
                if ($item['id'] != $parent['id']) {
                    $data[] = $item;
                }
                break;
            }
        }

        return $data;
    }

    /**
     * 获取导航根元素
     * @param null $id
     * @return |null
     */
    private function getMenuParentById($id = null) {

        $menus = $this->SITE_MENU['menus'];

        if (isset($menus[$id]) && !empty($menus[$id])) {
            $data = $menus[$id];
            if (!empty($data['parent_id'])) {
                return $this->getMenuParentById($data['parent_id']);
            }
            return $data;
        }

        return null;
    }

    /**
     * @param int $numPerPage
     */
    public function setPage($numPerPage = 10)
    {
        $page = !empty($this->request->getData('page')) ? $this->request->getData('page') : (!empty($this->request->getQuery('page')) ? $this->request->getQuery('page') : 1);

        $this->paginate['page'] = $page;
        $this->paginate['limit'] = $numPerPage;

        $this->set(compact('page', 'numPerPage'));

    }

    /**
     * 获取首页栏目
     * @return array
     */
    private function getHome()
    {
        $url = Router::url(['plugin' => 'Website', 'controller' => 'Home', 'action' => 'index']);
        return [
            'url' => $url,
            'name' => '首页',
            'parent_id' => 0
        ];
    }

    /**
     * 获取菜单树
     * @return array|bool|mixed
     */
    public function getMenusCache()
    {
        $data = Cache::read('site_menus', $this->CacheKey);

        if ($data === false) {
            // 所有栏目，key为id
            $cache = TableRegistry::getTableLocator()->get('Admin.SiteMenus')->find()
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ])
                ->each(function ($item){
                    $item['url'] = buildSiteUrl($item);
                })
                ->toArray();


            $menus = (new Collection($cache))
                ->nest('id', 'parent_id')
                ->listNested()
                ->indexBy('id')
                ->toArray();


            // 可见的栏目树
            $tree = (new Collection($cache))
                ->filter(function ($item) {
                    return $item['status'] == 1;
                })
                ->nest('id', 'parent_id')
                ->filter(function ($item) {
                    return $item['parent_id'] == 0;
                })
                ->toList();


            $home = $this->getHome();
            array_unshift($tree, $home);
            $data = [
                'menus' => $menus,
                'tree' => $tree
            ];

            Cache::write('site_menus', $data, $this->CacheKey);

        }

        return $data;

    }

    /**
     * 获取菜单
     * @return array
     */
    public function getSiteMenus()
    {
        return $this->SITE_MENU['tree'];
    }
}
