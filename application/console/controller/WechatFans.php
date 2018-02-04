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
 * @filename  WechatFans.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-03 16:27:32
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\WechatBase;
use service\WechatService;
use think\Db;

class WechatFans extends WechatBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function follow()
    {
        return $this->menusView();
    }

    public function tags()
    {
        return $this->menusView();
    }

    public function blacklist()
    {
        return $this->menusView();
    }

    /**
     * 同步粉丝列表
     */
    public function sync()
    {
        Db::name('WechatFans')->delete(true);
        if (WechatService::syncAllFans('')) {
            WechatService::syncBlackFans('');
            // LogService::write('微信管理', '同步全部微信粉丝成功');
            $this->success('同步获取所有粉丝成功！', '');
        }
        $this->error('同步获取粉丝失败，请稍候再试！');
    }

}
