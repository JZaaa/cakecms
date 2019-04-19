<?php


namespace App\View\Helper;

use Cake\View\Helper;

/**
 * 工具类
 * Class UtilHelper
 * @package App\View\Helper
 */
class UtilHelper extends Helper
{

    public $helpers = [
        'Url'
    ];

    /**
     * 生成按钮,过滤权限
     * 建议class统一 删除: [btn-danger], 新增：[btn-primary], 查询|编辑: [btn-info]
     * @param mixed ...$options
     *   [
     *      'name' => '按钮名',
     *      'class' => 'btn-danger otherclass',
     *      'url' => ['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'load'],
     *      'toggle' => 'dialog'
     *   ],
     *   ...
     *  或
     *   [
     *      'name' => '自动加载',
     *      'class' => 'btn-danger',
     *      'url' => ['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'load'],
     *      'data' => [
     *          'toggle' => 'doajax',
     *          'message' => 'data-message属性'
     *      ]
     *   ],
     *   ...
     * @return string
     */
    public function getBtn(...$options)
    {

        $count = count($options);

        if (!$count) {
            return '';
        }

        $user = $this->_View->getRequest()->getSession()->read('Admin.User');

        $btn = '';
        for ($i = 0; $i < $count; $i++) {
            $item = $options[$i];
            $url = isset($item['url']) ? $item['url'] : null;

            if (!$user['is_super'] && !in_array($url['plugin']. '.' . $url['controller'] . '.' .$url['action'], $user['router'])) {
                // 非超级权限，过滤
                continue;
            }

            $data = '';
            if (isset($item['toggle']) && !isset($item['data']['toggle'])) {
                $data .= ' data-toggle="' . $item['toggle'] . '" ';
            }

            if (isset($item['data'])) {
                foreach ($item['data'] as $key => $value) {
                    $data .= ' data-' . $key . '="' . $value . '" ';
                }
            }


            $data .= ' data-url="' . $this->Url->build($url) . '" ';

            $class = isset($item['class']) ? $item['class'] : 'btn-default';

            $btn .= '<button type="button" class="btn ' . $class  . '" '. $data .'>' . $item['name'] . '</button>&nbsp;';
        }

        return $btn;

    }

}