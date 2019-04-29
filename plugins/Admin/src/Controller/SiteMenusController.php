<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * SiteMenus Controller
 *
 * @property \Admin\Model\Table\SiteMenusTable $SiteMenus
 *
 * @method \Admin\Model\Entity\SiteMenu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SiteMenusController extends AppController
{

    public function index()
    {
        $data = $this->SiteMenus->findMenusTree();

        $types = $this->SiteMenus->getType();

        $status = $this->SiteMenus->getStatus();

        $this->set(compact('data', 'types', 'status'));
    }


    public function add()
    {
        if ($this->request->is('post')) {
            $data = $this->SiteMenus->newEntity();

            $newData = $this->request->getData();

            $data = $this->SiteMenus->patchEntity($data, $newData);

            if ($res = $this->SiteMenus->save($data)) {
                if ($res->type == 1) {
                    // 单页自动创建内容
                    TableRegistry::getTableLocator()->get('Admin.Articles')->createItem($res->id, $res->name);
                }
                $this->clearCacheAll();
                return $this->jsonResponse(200);
            }
            return $this->getError($data);
        }

        $this->ajaxView();

        $types = $this->SiteMenus->getType();

        $parents = $this->SiteMenus->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where([
                'parent_id' => 0
            ])
            ->toArray();
        // 获取模板列表
        $listTpls = Configure::read('listTpl');
        $contentTpls = Configure::read('contentTpl');

        $status = $this->SiteMenus->getStatus();


        $this->set(compact('types', 'parents', 'status', 'listTpls', 'contentTpls'));
    }

    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {
        $data = $this->SiteMenus->get($id);

        if ($this->request->is('post')) {
            $newData = $this->request->getData();

            $data = $this->SiteMenus->patchEntity($data, $newData);

            if ($this->SiteMenus->save($data)) {
                $this->clearCacheAll();
                return $this->jsonResponse(200);
            }
            return $this->getError($data);
        }

        $this->ajaxView();

        $types = $this->SiteMenus->getType();

        $parents = $this->SiteMenus->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where([
                'parent_id' => 0,
                'id <>' => $id
            ])
            ->toArray();
        // 获取模板列表
        $listTpls = Configure::read('listTpl');
        $contentTpls = Configure::read('contentTpl');

        $status = $this->SiteMenus->getStatus();

        $this->set(compact('types', 'parents', 'status', 'data', 'id', 'listTpls', 'contentTpls'));

    }


    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {

        if ($this->request->is('post')) {
            $data = $this->SiteMenus->get($id);

            if ($this->SiteMenus->delete($data)) {
                $this->clearCacheAll();
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300, false);

    }
}
