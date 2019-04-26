<?php
/**
 * 公共函数
 */

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