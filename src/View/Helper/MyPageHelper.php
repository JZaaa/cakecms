<?php

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * 自定义分页组件
 * Class MyPageHelper
 * @package App\View\Helper
 */
class MyPageHelper extends Helper
{
    public $helpers = [
        'Paginator'
    ];

    private $module = 5; // 最多显示分页数量
    private $prev = '«';
    private $next = '»';

    public function show()
    {
        $page = $this->Paginator->prev($this->prev);
        $page .= $this->Paginator->numbers(['modulus' => $this->module]);
        $page .= $this->Paginator->next($this->next);

        return '<div class="text-center"><ul class="pager">' . $page . '</ul></div>';
    }

}