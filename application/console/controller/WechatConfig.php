<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  WechatConfig.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-02 16:26:39
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\WechatBase;
use think\Db;

class WechatConfig extends WechatBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->assign('one', $this->config);
        return $this->menusView();
    }

    public function lists()
    {
        $data = Db::name('WechatConfig')->select();
        $this->assign('lists', $data);
        return $this->menusView();
    }

    public function details()
    {
        // dump($this->config);die;
        $this->assign('one', $this->config);
        return $this->menusView();
    }

}
