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
 * @filename  AuthRule.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 12:22:36
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\logic;

use think\facade\Cache;
use think\Model;

class AuthRule extends Model
{
    /**
     * { updateCache 更新缓存数据}
     * @Author   SpringYang
     * @DateTime 2017-10-24T14:14:25+0800
     * @return   [type]                   [description]
     */
    public function updateCache()
    {
        $data = self::order(['sort' => 'asc', 'id' => 'asc'])->select();
        Cache::set('authrule', $data->toArray());
        $this->updateCacheAuthModel();
    }

    /**
     * { updateCacheAuthModel 更新不需要权限验证的控制器、方法和不需要实例化模型缓存}
     * @Author   SpringYang
     * @DateTime 2017-10-24T13:15:05+0800
     * @return   [type]                   [description]
     */
    public function updateCacheAuthModel()
    {

        if (!Cache::get('authrule')) {
            return false;
        }

        $notAuth                 = []; // 不需要进行权限验证的方法
        $instantiationController = []; // 需要实列化的控制器

        foreach (Cache::get('authrule') as $val) {
            // 取得不需要进行权限验证
            if (!$val['auth'] && $val['status']) {
                $notAuth[] = strtolower($val['name']);
            }
            // 取得不需要实例化模型的控制器名称
            if ($val['controller'] && $val['instantiation']) {

                if (stripos($val['name'], '/')) {
                    $name = explode('/', $val['name']);
                    $name = $name[0];
                } else {
                    $name = $val['name'];
                }
                // $data['not_d_controller'][]         = $name;
                $instantiationController[] = toUnderline($name);

            }
            // dump($instantiation_controller);
            // $data['instantiation_controller'] = $instantiation_controller;
        }
        Cache::set('not_auth', $notAuth); // 缓存不需要进行权限验证
        Cache::set('instantiation_controller', $instantiationController); // 缓存需要实列化的控制器
    }
}
