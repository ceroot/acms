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
 * @filename  WechatBase.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-03 15:51:18
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\Base;
use think\Db;

class WechatBase extends Base
{
    protected $mid;
    protected $config = [];

    public function initialize()
    {
        parent::initialize();

        $this->app->request->has('mid') || $this->error('参数错误');
        $this->mid = deauthcode($this->app->request->param('mid'));
        $this->mid || $this->error('参数错误');
        $this->config = Db::name('WechatConfig')->find($this->mid);
        $this->config || $this->error('数据错误');

    }

}
