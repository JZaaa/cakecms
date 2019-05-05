<?php


namespace Website\Controller;


use Cake\ORM\TableRegistry;

class HomeController extends AppController
{

    public function index()
    {

        $sliders = TableRegistry::getTableLocator()->get('Admin.Sliders')
            ->getData();


        // 取3个
        $menus = array_slice($this->SITE_MENU['tree'], 1, 3);

        $Articles = TableRegistry::getTableLocator()->get('Admin.Articles');

        $data = [];

        foreach ($menus as $item) {
            if (empty($item['id'])) {
                continue;
            }

            if ($item['type'] == 1) {
                // 单页
                $tmp = $Articles->find()
                    ->select([
                        'id', 'site_menu_id', 'title', 'abstract', 'content'
                    ])
                    ->where([
                        'site_menu_id' => $item['id']
                    ])
                    ->first();

                $tmp['title'] = $item['name'];
                $data[] = $tmp;

            } else if ($item['type'] == 2) {
                // 列表
                $ids = [];

                $ids[] = $item['id'];

                if (!empty($item['children'])) {
                    foreach ($item['children'] as $value) {
                        $ids[] = $value['id'];
                    }
                }

                $tmp = $Articles->find()
                    ->select([
                        'id', 'site_menu_id', 'title', 'abstract', 'content'
                    ])
                    ->where([
                        'status' => 1,
                        'site_menu_id in' => $ids
                    ])
                    ->order([
                        'Articles.istop' => 'asc',
                        'Articles.id' => 'desc'
                    ])
                    ->limit(6)
                    ->all()
                    ->toArray();

                $tmp['title'] = $item['name'];
                $data[] = $tmp;

            }


        }

        $this->set(compact('sliders', 'data'));
    }

}