<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 http://beneng.com All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 * @filename
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2016-06-14 16:45:14
 * @site      http://www.benweng.com
 */
namespace app\common\behavior;

use think\facade\Config;

class ModuleInit
{
    public function run($params)
    {
        // dump(122);die;
        //$this->initialization(); // 初始化
        $this->config(); // 配置信息

    }

    // 初始化
    private function initialization()
    {
        //dump(987);
        //define('MODULE_NAME', request()->module());
        //define('CONTROLLER_NAME', request()->controller());
        //define('ACTION_NAME', request()->action());

    }

    // 配置信息处理
    private function config()
    {
        // 读取数据库中的配置并加入配置
        $config = cache('db_config_data');

        if (empty($config)) {
            $Config = new \app\common\model\Config;
            $config = $Config->cache_config();
        }
        foreach ($config as $key => $value) {
            Config::set($key, $value);
        }

        // Config::set($config); // 添加配置，5.0之前可以这样

    }

}
