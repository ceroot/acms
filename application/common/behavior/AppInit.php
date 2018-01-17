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
 * @filename  AppInit.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 10:18:03
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\behavior;

use think\facade\Cache;
use think\facade\Config;

class AppInit
{

    public function run($param)
    {
        $this->config(); // 配置信息处理
    }

    /**
     * [ config 配置信息处理 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-23T11:34:38+0800
     * @return   [type]                   [description]
     */
    private function config()
    {
        // 判断数据库中的配置是否存在，不存在设置并返回
        $config = Cache::remember('db_config_data', function () {
            $ConfigModel = new \app\common\model\Config;
            return $ConfigModel->cache_config();
        });

        // 配置输出
        foreach ($config as $key => $value) {
            switch ($key) {
                case 'value':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
            Config::set($key, $value);
        }

        // Config::set($config); // 添加配置，5.0之前可以这样

    }
}
