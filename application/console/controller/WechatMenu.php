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
 * @filename  WechatMenu.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-03 17:02:30
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\WechatBase;
use service\ToolsService;
use think\Db;

class WechatMenu extends WechatBase
{
    /**
     * 微信菜单的类型
     * @var array
     */
    protected $menuType = [
        'view'               => '跳转URL',
        'click'              => '点击推事件',
        'scancode_push'      => '扫码推事件',
        'scancode_waitmsg'   => '扫码推事件且弹出“消息接收中”提示框',
        'pic_sysphoto'       => '弹出系统拍照发图',
        'pic_photo_or_album' => '弹出拍照或者相册发图',
        'pic_weixin'         => '弹出微信相册发图器',
        'location_select'    => '弹出地理位置选择器',
    ];

    protected $wechat; // 微信实例化

    public function initialize()
    {
        parent::initialize();
        $this->wechat = new \WeChat\Menu($this->config); // 微信菜单实例化
    }

    public function index()
    {
        if ($this->app->request->isPost()) {
            $data = $this->app->request->param();
            $data = $data['data'];
            Db::name('WechatMenu')->where('mpid', $this->mpid)->delete(true); // 清空原有的

            foreach ($data as &$vo) {
                if (isset($vo['content'])) {
                    $vo['content'] = str_replace('"', "'", $vo['content']);
                }
                $vo['mpid'] = $this->mpid;
            }
            // return $data;
            if (Db::name('WechatMenu')->insertAll($data)) {
                $result = $this->_push(); // 推送到微信服务器
                $result ? $this->success('成功') : $this->error($result['errmsg']);
            } else {
                return $this->error('失败');
            };
        } else {
            $data = Db::name('WechatMenu')->where('mpid', $this->mpid)->select();
            $data = ToolsService::arr2tree($data, 'index', 'pindex');
            $this->assign('list', $data);
            return $this->menusView();
        }
    }

    public function getmenu()
    {
        $data = $this->wechat->get();
        dump($data);
    }

    /**
     * 菜单推送
     */
    public function _push()
    {
        // list($map, $fields) = [['status' => '1'], 'id,index,pindex,name,type,content'];
        $fields = 'id,index,pindex,name,type,content';
        $map    = [
            ['status', '=', 1],
            ['mpid', '=', $this->mpid],
        ];

        $result = (array) Db::name('WechatMenu')->where($map)->field($fields)->order('sort ASC,id ASC')->select();

        foreach ($result as &$row) {
            empty($row['content']) && $row['content'] = uniqid();
            if ($row['type'] === 'miniprogram'):
                list($row['appid'], $row['url'], $row['pagepath']) = explode(',', "{$row['content']},,");
            elseif ($row['type'] === 'view'):
                if (preg_match('#^(\w+:)?//#', $row['content'])) {
                    $row['url'] = $row['content'];
                } else {
                    $row['url'] = url($row['content'], '', true, true);
                } elseif ($row['type'] === 'event'):
                if (isset($this->menuType[$row['content']])) {
                    list($row['type'], $row['key']) = [$row['content'], "wechat_menu#id#{$row['id']}"];
                };
            elseif ($row['type'] === 'media_id'):
                $row['media_id'] = $row['content'];
            else:
                $row['key']                                              = "wechat_menu#id#{$row['id']}";
                !in_array($row['type'], $this->menuType) && $row['type'] = 'click';
            endif;
            unset($row['content']);
        }

        $menus = ToolsService::arr2tree($result, 'index', 'pindex', 'sub_button');

        //去除无效的字段
        foreach ($menus as &$menu) {
            unset($menu['index'], $menu['pindex'], $menu['id'], $menu['mpid']);
            if (empty($menu['sub_button'])) {
                continue;
            }
            foreach ($menu['sub_button'] as &$submenu) {
                unset($submenu['index'], $submenu['pindex'], $submenu['id'], $menu['mpid']);
            }
            unset($menu['type']);
        }

        $menus = ['button' => $menus]; // 增加 button

        try {
            if ($this->wechat->create($menus) !== false) {
                return ['status' => true, 'errmsg' => ''];
            } else {
                return ['status' => false, 'errmsg' => $this->wechat->getError()];
            }
        } catch (Exception $e) {
            // return $error = $e->getMessate();
            return ['status' => false, 'errmsg' => $e->getMessate()];
        }

    }

    /**
     * 取消菜单
     */
    public function cancel()
    {
        try {
            if (false !== $this->wechat->delete()) {
                return $this->success('菜单取消成功，重新关注可立即生效！');
            } else {
                return $this->error('菜单取消失败，' . $this->wechat->getError());
            }
        } catch (Exception $e) {
            return $this->error($e->getMessate());
        }
    }

}
