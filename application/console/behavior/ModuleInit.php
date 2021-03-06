<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  ModuleInit.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 12:13:49
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\behavior;

use think\facade\App;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Log;

class ModuleInit
{

    public function run($params)
    {
        $this->initialization();
        $this->cacheAuthRule(); // 缓存规则表数据
    }

    /**
     * [ initialization 初始化 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-26T11:02:54+0800
     * @return   [type]                   [description]
     */
    private function initialization()
    {

    }

    /**
     * { cacheAuthRule 缓存规则表数据 }
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-24T12:16:31+0800
     * @return   [type]                   [description]
     */
    private function cacheAuthRule()
    {
        // 判断是否进行缓存
        if (!Cache::get('authrule') || Config::get('app_debug')) {
            App::model('AuthRule', 'logic')->updateCache();

            Log::record('[ 规则缓存日志 ]：执行规则缓存成功（模块初始化）');
        }

    }

}
