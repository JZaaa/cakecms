<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * 轮播图
 * Sliders Controller
 *
 * @property \Admin\Model\Table\SlidersTable $Sliders
 *
 * @method \Admin\Model\Entity\Slider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SlidersController extends AppController
{

    /**
     * 浏览
     */
    public function index()
    {
        $conditions = [];


        $query = $this->Sliders->find()
            ->where($conditions)
            ->order([
                'sort' => 'desc',
                'id' => 'desc'
            ]);

        $data = $this->paginate($query);

        $this->set(compact('data'));
    }


    /**
     * 新增
     * @return \App\Controller\AppController
     */
    public function add()
    {

        if ($this->request->is('post')) {
            $data = $this->Sliders->newEntity();

            $newData = $this->request->getData();

            if (empty($newData['tag'])) {
                $newData['tag'] = !empty($newData['newtag']) ? $newData['newtag'] : 'home';
            }

            $data = $this->Sliders->patchEntity($data, $newData);

            if ($this->Sliders->save($data)) {
                return $this->jsonResponse(200);
            }

            return $this->getError($data);
        }
        $tags = $this->Sliders->find('list', [
            'keyField' => 'id',
            'valueField' => 'tag'
        ])
            ->where([
                'tag <>' => 'home'
            ])
            ->distinct('tag')
            ->toArray();

        $this->ajaxView();

        $this->set(compact('tags'));

    }


    /**
     * 编辑
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function edit($id = null)
    {

        $data = $this->Sliders->get($id);

        if ($this->request->is('post')) {
            $newData = $this->request->getData();

            $data = $this->Sliders->patchEntity($data, $newData);

            if ($this->Sliders->save($data)) {
                return $this->jsonResponse(200);
            }

            return $this->getError($data);
        }

        $tags = $this->Sliders->find('list', [
            'keyField' => 'id',
            'valueField' => 'tag'
        ])
            ->distinct('tag')
            ->toArray();

        $this->ajaxView();

        $this->set(compact('data', 'tags', 'id'));

    }

    /**
     * 删除
     * @param null $id
     * @return \App\Controller\AppController
     */
    public function delete($id = null)
    {

        if ($this->request->is('post')) {
            $data = $this->Sliders->get($id);

            if ($this->Sliders->delete($data)) {
                return $this->jsonResponse(200);
            }
        }

        return $this->jsonResponse(300, false);

    }

}
