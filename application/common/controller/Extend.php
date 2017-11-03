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
 * @filename  Extend.php 基类控制器
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-30 15:28:24
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\controller;

use think\Container;
use think\Controller;

class Extend extends Controller
{
    protected $app; //容器实例

    /**
     * @name   initialize          [初始化]
     * @author SpringYang <ceroot@163.com>
     * @dateTime
     */
    public function initialize()
    {
        $this->app = Container::getInstance()->make('think\App');

        // 关于服务端url没有#!的处理
        if ($this->app->request->isPut()) {
            $hash = $this->app->request->param('hash');
            if ($hash) {
                $this->app->session->set('hash', $hash);
            } else {
                $this->app->session->set('hash', null);
            }
        } else {
            $this->app->session->set('hash', null);
        }

    }
}
