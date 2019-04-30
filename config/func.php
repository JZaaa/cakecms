<?php
/**
 * 公共函数
 */

use Cake\Cache\Cache;
use Cake\Routing\Router;

if (!function_exists('extractUrl')) {
    /**
     * 去除url附加参数
     * @param $url string
     * @return string
     */
    function extractUrl($url)
    {
        return explode('?', $url)[0];
    }
}

if (!function_exists('buildSiteUrl')) {
    /**
     * 生成网站url
     * @param $siteMenu
     * @return mixed|string
     */
    function buildSiteUrl($siteMenu)
    {
        return empty($siteMenu['link']) ?
            (
                empty($siteMenu['custom_url']) ?
                Router::url(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'index', $siteMenu['id']]) :
                Router::url($siteMenu['custom_url'])
            ) :
            $siteMenu['link'];

    }
}

if (!function_exists('checkCustomUrl')) {
    /**
     * 用户自定义url验证
     * @param $url
     * @return array
     */
    function checkCustomUrl($url)
    {
        $url = trim($url, " \t\n\r\0\x0B/");

        $array = explode('/', $url);
        $error = false;

        if (!empty($array)) {
            foreach ($array as $key=>$item) {
                if (in_array(strtolower($item), ['admin', 'home', 'page'])) {
                    $error = '首个路径段不能存在保留路径:[\'admin\', \'home\', \'page\']';
                    break;
                }
                if (empty($item)) {
                    $error = '路径段不能为空';
                    break;
                }
                if (is_numeric($item)) {
                    $error = '路径段不能存在纯数字';
                    break;
                }
                if (!preg_match('/^(\w|\-)+$/', $item)) {
                    $error = '路径段只能存在数字、字母、下划线、-、/';
                    break;
                }
            }
        }

        if ($error === false) {
            return [
                'error' => false,
                'url' => '/' . $url
            ];
        }

        return [
            'error' => true,
            'message' => $error
        ];
    }
}

if (!function_exists('getSiteCache')) {
    /**
     * 获取网站配置缓存信息
     * @return mixed|string
     */
    function getSiteCache()
    {
        $data = Cache::read('site_cache', 'site');

        if ($data === false) {
            // 所有栏目，key为id
            $data = \Cake\ORM\TableRegistry::getTableLocator()->get('Admin.Options')->find()
                ->where([
                    'tag' => 'site'
                ])
                ->indexBy('key_field')
                ->toArray();

            Cache::write('site_cache', $data, 'site');

        }

        return $data;

    }
}


if (!function_exists('formatEnter')) {
    /**
     * 格式化换行，每行格式化为数组
     * @param $string
     * @return array
     */
    function formatEnter($string)
    {
        $data = !empty($string) ? explode("\r\n", $string) : [];
        return $data;
    }
}