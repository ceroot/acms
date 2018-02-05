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
 * @filename  WechatFansTags.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-04 17:21:25
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\WechatBase;
use service\WechatService;
use think\Db;

class WechatFansTags extends WechatBase
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $data = Db::name('WechatFansTags')->select();
        $this->assign('lists', $data);
        return $this->menusView();
    }

    /**
     * 同步粉丝标签列表
     */
    public function sync()
    {
        Db::name('WechatFansTags')->delete(true);
        if (WechatService::syncFansTags()) {
            // LogService::write('微信管理', '同步全部微信粉丝标签成功');
            //$this->success('同步获取所有粉丝标签成功!', '');
        }
        //$this->error('同步获取粉丝标签失败, 请稍候再!');
    }
}
