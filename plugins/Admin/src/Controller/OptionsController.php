<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Options Controller
 *
 * @property \Admin\Model\Table\OptionsTable $Options
 *
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionsController extends AppController
{

    public function index()
    {
        $data = $this->Options->find()
            ->where([
                'tag' => 'site'
            ])
            ->all()
            ->indexBy('key_field')
            ->toArray();

        if ($this->request->is('post')) {
            $newData = $this->request->getData();
            $saveData = [];

            foreach ($newData as $key => $item) {
                // 存在
                if (isset($data[$key])) {
                    $saveData[] = [
                        'id' => $data[$key]['id'],
                        'value_field' => $item['value_field'],
                        'name' => $item['name']
                    ];
                } else {
                    $saveData[] = [
                        'name' => $item['name'],
                        'key_field' => $key,
                        'value_field' => $item['value_field'],
                        'tag' => 'site'
                    ];
                }
            }

            $entity = $this->Options->patchEntities($data, $saveData);

            try {
                $this->Options->saveMany($entity);
                $this->clearCacheAll();
                return $this->jsonResponse(200, false, [], '保存成功!', false, false, false);
            } catch (\Exception $e) {
                return $this->jsonResponse(300);
            }
        }

        $this->set(compact('data'));
    }

}
