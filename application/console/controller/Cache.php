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
 * @filename  Action.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-27 16:44:07
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;
use Dir;
use think\facade\Env;
use think\facade\Hook;
use think\facade\Session;

class Cache extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * [ cache 更新缓存 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-30T15:27:14+0800
     * @return   [type]                   [description]
     */
    public function cache()
    {
        $runTimePath = Env::get('runtime_path'); // 运行目录
        $msg         = '';

        if ($this->app->request->isAjax()) {
            if (Session::has('action')) {
                $action = Session::get('action');
            } else {
                $action = $this->app->request->param('action/a');
                Session::set('action', $action);
            }

            $current = array_shift($action);
            Session::set('action', $action);
            switch (strtolower($current)) {
                case 'config':
                    $Config = new \app\common\model\Config;
                    $config = $Config->cache_config();
                    $msg    = '网站配置';
                    break;
                case 'category':
                    $msg = '栏目缓存';
                    //D('Category')->update_cache();
                    break;
                case 'table':

                    $msg = '数据表缓存';
                    break;
                case 'rule':
                    $this->app->model('authRule')->updateCache();
                    $msg = '规则表缓存';
                    break;
                case 'ueditor':
                    $ueditorPath = './data/ueditor/';

                    Dir::del($ueditorPath . 'file');
                    Dir::del($ueditorPath . 'images');
                    Dir::del($ueditorPath . 'video');

                    Dir::create($ueditorPath . 'file');
                    Dir::create($ueditorPath . 'images');
                    Dir::create($ueditorPath . 'video');
                    $msg = 'ueditor 暂存目录';
                    break;
                case 'temp':
                    $tempPath = '../data/temp';
                    Dir::del($tempPath);
                    Dir::create($tempPath);
                    $msg = '临时目录';
                    break;
                case 'sdk_config':
                    \Cache::rm('oauth_sdk_config');
                    $msg = '第三方登录 SDK 缓存';
                    break;
                case 'runtime':
                    // is_file(RUNTIME_PATH . 'common~runtime.php') &&
                    // unlink(RUNTIME_PATH . 'common~runtime.php');
                    //Dir::del(RUNTIME_PATH . 'temp');
                    //Dir::del(RUNTIME_PATH . 'data');
                    //Dir::del(RUNTIME_PATH . 'logs');
                    Dir::del($runTimePath . 'temp');
                    Dir::create($runTimePath . 'temp');
                    Dir::del($runTimePath . 'cache');
                    Dir::create($runTimePath . 'cache');
                    $msg = '运行目录（runtime）...';
                    break;
                case 'other':

                    $msg = '其它缓存';
                    break;
                default:
                    // $msg = '没有默认跳过';
                    # code...
                    break;
            }

            $data['type'] = $current;
            $data['end']  = 0;
            Session::set('logText', $msg);

            if (count($action) == 0) {
                $msg         = '全部缓存更新成功';
                $data['end'] = 1;
                Session::delete('action'); // 删除 action
            }

            Hook::listen('action_log', ['record_id' => 0]);
            return $this->success($msg, '', $data);

        } else {
            return $this->menusView();
        }

    }

    /**
     * [ resetcache 重置更新缓存 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:51:30+0800
     * @return   [type]                   [description]
     */
    public function resetcache()
    {
        Session::delete('action');
        return $this->success('重置成功');
    }
}
