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
 * @filename  Wechat.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-02 16:55:56
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\Base;
use think\Db;

class Wechat extends Base
{
    public function initialize()
    {
        parent::initialize();
        // dump(1);
    }

    public function index()
    {
        $data = Db::name('WechatConfig')->select();
        // dump($data);die;
        $this->assign('lists', $data);
        return $this->menusView();
    }

}
