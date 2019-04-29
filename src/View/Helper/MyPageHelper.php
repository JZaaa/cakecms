<?php

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * 自定义页面助手
 * Class MyPageHelper
 * @package App\View\Helper
 */
class MyPageHelper extends Helper
{
    public $helpers = [
        'Paginator'
    ];

    private $module = 5; // 最多显示分页数量
    private $prev = '上一页';
    private $next = '下一页';

    /**
     * 生成自定义分页
     * @return string
     */
    public function show()
    {
        $page = $this->Paginator->prev($this->prev);
        $page .= $this->Paginator->numbers(['modulus' => $this->module]);
        $page .= $this->Paginator->next($this->next);

        return '<div class="text-center"><ul class="pager">' . $page . '</ul></div>';
    }

    /**
     * 无数据显示
     * @return string
     */
    public function noData()
    {
       return '<div class="text-center" style="height: 100px;line-height: 100px">没有更多内容了...</div>';
    }

}