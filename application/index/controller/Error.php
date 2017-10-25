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
 * @filename  Error.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 11:18:40
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\index\controller;

use think\facade\Log;
use think\Request;

class Error
{
    public function index(Request $request)
    {
        //根据当前控制器名来判断要执行那个城市的操作
        $controllerName = $request->controller();
        return $this->showController($controllerName);
    }

    //注意 showController 方法 本身是 protected 方法
    protected function showController($name)
    {
        Log::record('[ 空控制器 ]：' . $name . ' 此控制器不存在');
        //和$name相关的处理
        return '当前控制器不存在，控制器名为：' . $name;
    }

    // 空操作
    public function _empty($name)
    {
        //把所有空操作解析到 showAction 方法
        return $this->showAction($name);
    }

    //注意 showAction 方法 本身是 protected 方法
    protected function showAction($name)
    {
        Log::record('[ 空方法 ]：' . $name . '此方法不存在');
        //和$name这个城市相关的处理
        return '当前操作方法不存在，操作方法名为：' . $name;
    }
}
