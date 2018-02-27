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
    protected $mpid;
    protected $config = [];

    protected $wechat;

    public function initialize()
    {
        parent::initialize();

        $this->app->request->has('mpid') || $this->error('参数错误');
        $this->mpid = deauthcode($this->app->request->param('mpid')); // 解密
        $this->mpid || $this->error('参数错误');
        $this->config = Db::name('WechatConfig')->find($this->mpid); // 查询配置参数
        $this->config || $this->error('数据错误');

    }

}
