<?php
/**
 * Created by PhpStorm.
 * User: jzaaa
 * Date: 2019/4/4
 * Time: 13:47
 */

namespace Admin\Controller;


use Cake\Core\Configure;

class HomeController extends AppController
{
    // 主页
    public function index()
    {
        $this->serverEnv();

        $user = $this->USER;
        $this->set(compact('user'));
    }


    /**
     * 服务器信息
     */
    public function serverEnv()
    {
        $data = $this->getRequest()->getServerParams();

        $env = [
            [
                'value' => $data['HTTP_HOST'],
                'label' => '服务器域名'
            ],
            [
                'value' => $data['SERVER_SOFTWARE'],
                'label' => '服务器环境'
            ],
            [
                'value' => $data['SERVER_ADDR'],
                'label' => '服务器IP'
            ],
            [
                'value' => PHP_OS,
                'label' => '服务器系统'
            ],
            [
                'value' => 'CakePHP ' . Configure::version(),
                'label' => '框架版本'
            ],
            [
                'value' => function_exists('gzclose') ? 'YES' : 'NO',
                'label' => 'Zlib支持'
            ],
            [
                'value' => (boolean) ini_get('safe_mode') ? 'YES' : 'NO',
                'label' => '安全模式'
            ],
            [
                'value' => phpversion(),
                'label' => 'PHP版本'
            ],
            [
                'value' => ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown',
                'label' => '文件上传限制'
            ],
            [
                'value' => ini_get("max_execution_time") . 's',
                'label' => '脚本最大执行时间'
            ],
            [
                'value' => ini_get('memory_limit'),
                'label' => '最大占用内存'
            ],
            [
                'value' => implode('，', get_loaded_extensions()),
                'label' => '加载模块'
            ]

        ];


        $this->set(compact('env'));
    }

}