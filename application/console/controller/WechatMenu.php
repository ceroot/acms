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

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        if ($this->app->request->isPost()) {
            $data = $this->app->request->param();
            // $post = $this->app->reques->post();
            // $data = $post['data'];
            $data = $data['data'];
            Db::name('WechatMenu')->where('mid', $this->mid)->delete(true);
            // Db::name('WechatMenu')->delete(true);
            // Db::name('WechatMenu')->delete(true);
            foreach ($data as &$vo) {
                if (isset($vo['content'])) {
                    $vo['content'] = str_replace('"', "'", $vo['content']);
                }
                $vo['mid'] = $this->mid;
            }
            // return $data;
            if (Db::name('WechatMenu')->insertAll($data)) {
                $result = $this->_push();
                // $result = 1;
                // if ($result) {
                //     $this->success('成功');
                // } else {
                //     $this->error($result['errmsg']);
                // }
                $result ? $this->success('成功') : $this->error($result['errmsg']);
            } else {
                return $this->error('失败');
            };
        } else {
            $data = Db::name('WechatMenu')->where('mid', $this->mid)->select();
            $data = ToolsService::arr2tree($data, 'index', 'pindex');
            $this->assign('list', $data);
            return $this->menusView();
        }
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
            ['mid', '=', $this->mid],
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
            unset($menu['index'], $menu['pindex'], $menu['id'], $menu['mid']);
            if (empty($menu['sub_button'])) {
                continue;
            }
            foreach ($menu['sub_button'] as &$submenu) {
                unset($submenu['index'], $submenu['pindex'], $submenu['id'], $menu['mid']);
            }
            unset($menu['type']);
        }

        $menus = ['button' => $menus]; // 增加 button

        $wechat = load_wechat('Menu', $this->mid);
        if (false !== $wechat->createMenu($menus)) {
            return ['status' => true, 'errmsg' => ''];
        }
        return ['status' => false, 'errmsg' => $wechat->getError()];
    }

    /**
     * 取消菜单
     */
    public function cancel()
    {
        $wehcat = load_wechat('Menu', $this->mid);
        if (false !== $wehcat->deleteMenu()) {
            $this->success('菜单取消成功，重新关注可立即生效！', '');
        }
        $this->error('菜单取消失败，' . $wehcat->getError());
    }

}
