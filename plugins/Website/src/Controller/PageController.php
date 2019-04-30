<?php

/**
 * 栏目选择模板渲染
 */
namespace Website\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

/**
 * Class PageController
 * @property \Admin\Model\Table\SiteMenusTable $SiteMenus
 * @property \Admin\Model\Table\ArticlesTable $Articles
 *
 * @method \Admin\Model\Entity\SiteMenu[]|\Admin\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @package Website\Controller
 */
class PageController extends AppController
{

    protected $SiteMenus;
    protected $Articles;

    public function initialize()
    {
        parent::initialize();
        $this->SiteMenus = TableRegistry::getTableLocator()->get('Admin.SiteMenus');
        $this->Articles = TableRegistry::getTableLocator()->get('Admin.Articles');
    }


    /**
     * 页面主入口
     * @param null|int|\Cake\Datasource\EntityInterface $menu_id, int 类型为栏目id,实现EntityInterface接口为直接传递栏目实体
     */
    public function index($menu_id = null)
    {
        if ($menu_id instanceof \Cake\Datasource\EntityInterface) {
            $menu = $menu_id;
        } else {
            $menu = isset($this->SITE_MENU['menus'][$menu_id]) ? $this->SITE_MENU['menus'][$menu_id] : null;
        }

        if (empty($menu)) {
            throw new NotFoundException();
        }

        switch ($menu['type']) {
            case 1: // 单页渲染
                $this->singlePageRender($menu);
                break;
            case 2: // 列表渲染
                $this->listPageRender($menu);
                break;
            default:
                $this->pageRender(null);
        }
    }

    /**
     * 单页渲染
     * @param $menu
     */
    private function singlePageRender($menu)
    {
        $data = $this->Articles->find()
            ->where([
                'site_menu_id' => $menu['id']
            ])
            ->firstOrFail();

        $this->set(compact('data'));

        $this->pageRender($menu['content_tpl']);
    }

    /**
     * 列表渲染
     * @param $menu
     */
    private function listPageRender($menu)
    {
        $this->setPage();

        $ids = [];
        foreach ($menu['children'] as $item) {
            $ids[] = $item['id'];
        }

        $ids[] = $menu['id'];

        $query = $this->Articles->find()
            ->select([
                'id', 'site_menu_id', 'title', 'color', 'subtitle', 'thumb', 'date', 'visit', 'abstract', 'istop'
            ])
            ->where([
                'status' => 1,
                'site_menu_id in' => $ids
            ])
            ->order([
                'Articles.istop' => 'asc',
                'Articles.id' => 'desc'
            ]);

        $data = $this->paginate($query);

        $this->set(compact('data'));

        $this->pageRender($menu['list_tpl']);
    }

    /**
     * 页面渲染
     * @param null $tpl
     */
    private function pageRender($tpl = null)
    {
        if (empty($tpl)) {
            throw new NotFoundException('模板渲染不正确');
        }
        $this->render('/Tpl/' . $tpl);
    }

    /**
     * 内容查看
     * @param null $id
     */
    public function view($id = null)
    {

        $tmp = $this->request->getQuery('tmp');

        $conditions = [];
        if (!empty($tmp) && !$this->getRequest()->getSession()->read('Admin.User')) {
            throw new UnauthorizedException('无权限访问', 403);
        } else if (empty($tmp)) {
            $conditions['Articles.status'] = 1;
        }


        $data = $this->Articles->get($id, [
            'conditions' => $conditions,
            'contain' => [
                'SiteMenus' => [
                    'fields' => [
                        'id', 'name', 'type', 'content_tpl'
                    ]
                ]
            ]
        ]);

        // 文章上一篇下一篇
        $round = $this->Articles->getRound($id, $data['site_menu']['id']);


        if (empty($tmp)) {
            $this->Articles->addVisit($data);
        }

        $this->ACTIVE_NAV_ID = $data['site_menu']['id'];

        $this->set(compact('data', 'round'));

        $this->pageRender($data['site_menu']['content_tpl']);
    }

    /**
     * 自定义url
     */
    public function custom()
    {
        $url = $this->request->getPath();
        $menu = $this->SiteMenus->find()
            ->where([
                'custom_url' => $url
            ])
            ->firstOrFail();

        $this->ACTIVE_NAV_ID = $menu['id'];

        $this->index($menu);
    }


}