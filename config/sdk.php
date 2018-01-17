<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  sdk.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-12-07 13:42:10
 * @site      http://www.benweng.com
 * @version   $Id$
 */
define('URL_CALLBACK', 'http://192.168.1.9:888/index/oauth/callback?type=');
return [
    //腾讯QQ登录配置
    'qq'     => [
        'app_key'    => '101293495', // 应用注册成功后分配的 APP ID
        'app_secret' => '1196cd54f6aec6cb57c2b6f91a9a0f98', //应用注册成功后分配的KEY
        'callback'   => URL_CALLBACK . 'qq',
    ],
    'weixin' => [
        'app_key'    => 'app_key', // 应用注册成功后分配的 APP ID
        'app_secret' => 'app_secret', //应用注册成功后分配的KEY
        'callback'   => '',
    ],
    'sina'   => [
        'app_key'    => '1667660948', // 应用注册成功后分配的 APP ID
        'app_secret' => 'fb01aa84fd0d5ca15c9121366ae22518', //应用注册成功后分配的KEY
        'callback'   => URL_CALLBACK . 'sina',
    ],
];
