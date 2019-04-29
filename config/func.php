<?php
/**
 * 公共函数
 */

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
        return empty($siteMenu['link']) ? Router::url(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'index', $siteMenu['id']]) : $siteMenu['link'];

    }
}