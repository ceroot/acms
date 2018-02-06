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
use think\facade\Log;

class WechatFans extends WechatBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function follow()
    {
        $this->app->cookie->set('__forward__', $_SERVER['REQUEST_URI']);
        if ($this->app->request->isAjax()) {
            $redata = $this->_lists(); // 返回的数据
            $count  = $redata['count']; // 总条数
            $data   = $redata['data']; // 当年

            return $this->success('成功', '', $data, $count);
        } else {
            return $this->menusView();
        }
    }

    public function followtest()
    {
        $newList = $this->_lists();
        dump($newList);
    }

    public function blacklist()
    {
        $this->app->cookie->set('__forward__', $_SERVER['REQUEST_URI']);
        if ($this->app->request->isAjax()) {
            $map = [
                ['is_back', '=', 1],
            ];
            $redata = $this->_lists($map); // 返回的数据
            $count  = $redata['count']; // 总条数
            $data   = $redata['data']; // 当年

            return $this->success('成功', '', $data, $count);
        } else {
            return $this->menusView();
        }
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
            // $this->success('同步获取所有粉丝成功！', '');
        }
        // $this->error('同步获取粉丝失败，请稍候再试！');
    }

    public function synctest()
    {
        try {

            // 实例接口
            $wechat = new \WeChat\User($this->config);

            // 执行操作
            $result = $wechat->getUserList('odL5RwoalBUe4nrmyrZ27FvykwjE');
            dump($result);

            $userInfo = $wechat->getBatchUserInfo($result['data']['openid']);

            dump($userInfo);

            // foreach ($result['data']['openid'] as $value) {
            //     $userInfo = $wechat->getBatchUserInfo($value);
            //     dump($userInfo);
            // }

        } catch (Exception $e) {
            // 异常处理
            echo $e->getMessage();
        }
    }

    public function synctest1($next_openid = '')
    {
        // 实例接口
        $wechat = new \WeChat\User($this->config);

        $result = $wechat->getUserList($next_openid);
        dump($result);
        if ($result === false || empty($result['next_openid'])) {
            // Log::error("获取用户信息失败, {$wechat->errMsg} [{$wechat->errCode}]");
            Log::error("获取用户信息失败");
            return false;
        }

        foreach (array_chunk($result['data']['openid'], 100) as $openids) {

            if (false === ($userInfo = $wechat->getBatchUserInfo($openids)) || !is_array($userInfo)) {
                Log::error("获取用户信息失败, {$wechat->errMsg} [{$wechat->errCode}]");
                return false;
            }

            dump($userInfo);

        }
        // dump($wechat->getUserList('odL5RwoalBUe4nrmyrZ27FvykwjE'));
        // $userInfo = $wechat->getBatchUserInfo($result['data']['openid']);
        return empty($result['next_openid']) ? true : self::synctest1($result['next_openid']);
    }

}
