<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  AuthRule.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 12:22:36
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\logic;

use app\common\model\Extend;
use app\facade\Auth;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Session;

class AuthRule extends Extend
{

    /**
     * { updateCache 更新缓存数据}
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-24T14:14:25+0800
     * @return   [type]                   [description]
     */
    public function updateCache()
    {
        $data = self::order(['sort' => 'asc', 'id' => 'asc'])->select();
        Cache::set('authrule', $data->toArray());
        $this->updateCacheAuthModel();
    }

    /**
     * { updateCacheAuthModel 更新不需要权限验证的控制器、方法和不需要实例化模型缓存}
     * @author   SpringYang
     * @email    ceroot@163.com
     * @DateTime 2017-10-24T13:15:05+0800
     * @return   [type]                   [description]
     */
    public function updateCacheAuthModel()
    {
        // if (!Cache::has('authrule')) {
        //     return false;
        // }
        $notAuth                 = []; // 不需要进行权限验证的方法
        $instantiationController = []; // 需要实列化的控制器

        foreach (Cache::get('authrule') as $val) {
            // 取得不需要进行权限验证
            (!$val['auth'] && $val['status']) && $notAuth[] = strtolower($val['name']);
            // 取得不需要实例化模型的控制器名称
            if ($val['controller'] && $val['instantiation']) {
                if (stripos($val['name'], '/')) {
                    $name = explode('/', $val['name']);
                    $name = $name[0];
                } else {
                    $name = $val['name'];
                }
                $instantiationController[] = toUnderline($name);

            }
        }
        Cache::set('not_auth', $notAuth); // 缓存不需要进行权限验证
        Cache::set('instantiation_controller', $instantiationController); // 缓存需要实列化的控制器
    }

    /**
     * [ consoleMenu 生成后台菜单并缓存 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:01:27+0800
     * @return   [type]                   [description]
     */
    public function consoleMenu()
    {
        $data = Cache::get('authrule');
        // 判断是不是超级管理员
        if (in_array(Session::get('manager_id'), Config::get('auth_superadmin'))) {
            // $data = $cache;
        } else {
            // 根据用户id来选择id所对应的用户拥有的显示数据
            // 满足条件
            // 1 权限管理所拥有的
            // 2 不需要进行权限验证的
            $notAuth = Cache::get('not_auth'); // 从缓存取得不需要进行权限验证的数据
            // dump($notAuth);die;
            // $data = [];
            foreach ($data as &$value) {
                if (Auth::check($value['name'], Session::get('manager_id')) || in_array(strtolower($value['name']), $notAuth)) {
                    // $data[] = $value;
                }

            }
        }

        $navdata = [];
        foreach ($data as $value) {
            if ($value['status']) {
                // 激活当前处理
                $value['active'] = 0;
                $controller      = toCamel(request()->controller());
                $action          = toCamel(request()->action());

                // 微信管理菜单显示
                if (strstr(strtolower($controller), 'wechat') === false) {
                    if (strstr(strtolower($value['name']), 'wechat') !== false && strtolower($value['name']) != 'wechat') {
                        continue;
                    }
                } else {
                    if (strtolower($controller) == 'wechat') {
                        if (strstr(strtolower($value['name']), 'wechat') &&
                            strtolower($value['name']) != 'wechat' &&
                            strtolower($value['name']) != 'wechat/index'
                        ) {
                            continue;
                        }
                    }
                }

                // 取得当前控制器id与方法id
                if (strtolower($value['name']) == strtolower($controller . '/' . $action)) {
                    $currentData = [
                        'action_id'     => $value['id'],
                        'controller_id' => $value['pid'],
                    ];
                }

                // 处理 url
                switch ($value['name']) {
                    case 'index/index':
                        $time = date('YmdHis') . getrandom(128);
                        $url  = url('console/index/index?time=' . $time);
                        # code...
                        break;
                    case 'manager/log': // 管理员管理
                        // $name = url($name, array('role' => 1));
                        $url = url('actionLog/list', array('role' => 1));
                        break;
                    case 'UserComment/index': // 评论管理
                        $url = url($name, array('verifystate' => 1));
                        break;
                    case '':
                        $url = '';
                        break;
                    default:
                        $url = $value['url'] ?: url($value['name']);
                }
                // 微信管理 url 处理
                if (strstr(strtolower($value['name']), 'wechat') && strtolower($value['name']) != 'wechat/index') {
                    $url = $value['url'] ?: url($value['name'], ['mpid' => input('mpid')]);
                }
                $value['url'] = $url;
                $navdata[]    = $value;
            }
        }

        // dump($navdata);die;

        // 判断处理
        if (!isset($currentData)) {
            $this->error = '规则表里不存在此名称，请先进行规则添加';
            return false;
        }

        // 处理当前高亮标记
        // 子级返回父级数组
        $bread = get_parents($navdata, $currentData['action_id']);

        // 只取id组成数组
        $activeidarr = [];
        foreach ($bread as $value) {
            $activeidarr[] = $value['id'];
        }
        // 高亮标识
        $activedata = [];
        foreach ($navdata as $value) {
            if (in_array($value['id'], $activeidarr)) {
                $value['active'] = 1;
            }
            $activedata[] = $value;
        }
        // 子菜单
        $second = null;
        if (count($activeidarr) > 2) {
            foreach ($activedata as $value) {
                if ($currentData['controller_id'] == $value['id']) {
                    $producttitle = $value['title'];
                    break;
                }
            }
            $second['title'] = $producttitle;
            $second['data']  = get_cate_by_pid($activedata, $currentData['controller_id']);
        } else {
            foreach ($activedata as $value) {
                if ($currentData['action_id'] == $value['id']) {
                    $producttitle = $value['title'];
                    break;
                }
            }
            $second['title'] = $producttitle;
            $second['data']  = get_chi_ids($navdata, $currentData['action_id']);
        }
        $treeArray['second']    = $second; // 二级菜单数据
        $treeArray['bread']     = $bread; // 面包萱
        $treeArray['showtitle'] = end($bread)['title']; // 当前标题

        // 去掉不需要显示的
        $showData = [];
        foreach ($activedata as $key => $value) {
            if ($value['isnavshow'] == 1) {
                $showData[] = $value;
            }
        }
        $treeArray['menu'] = get_cate_tree_arr($showData, 0); // 生成树形结构$showData
        return $treeArray;
    }

}
