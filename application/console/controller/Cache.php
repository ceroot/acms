<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
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

class Cache extends Base
{
    public function initialize()
    {
        parent::initialize();

    }

    public function cache()
    {
        // $action = input('post.');
        // cache('action', $action['action']);
        // return $this->success('准备更新...', url('cache/update'));

        // die;
        if ($this->app->request->isAjax()) {
            if (!$this->app->cache->has('action')) {
                $action = $this->app->request->param();
                $action = $action['action'];
                $this->app->cache->set('action', $action);

            } else {
                $action = $this->app->cache->get('action');
            }

            $current = array_shift($action);
            $this->app->cache->set('action', $action);

            if (!empty($action)) {
                switch ($current) {
                    case 'Config':
                        $Config = new \app\common\model\Config;
                        $config = $Config->cache_config();
                        $msg    = '网站配置更新成功...';
                        break;
                    case 'Category':
                        $msg = '栏目缓存更新成功...';
                        //D('Category')->update_cache();
                        break;
                    case 'Table':

                        $msg = '数据表缓存更新成功...';
                        break;
                    case 'rule':
                        //Dir::del(RUNTIME_PATH . 'cache');
                        model('authRule')->updateCache();
                        $msg = '规则表缓存更新成功...';
                        break;
                    case 'ueditor':
                        //Dir::del(RUNTIME_PATH . 'cache');
                        Dir::del('./data/ueditor/file');
                        Dir::del('./data/ueditor/images');
                        Dir::del('./data/ueditor/video');
                        $msg = 'ueditor 暂存目录更新成功...';
                        break;
                    case 'sdk_config':
                        cache('oauth_sdk_config', null);
                        $msg = '第三方登录SDK缓存更新成功...';
                        break;
                    case 'other':
                        // is_file(RUNTIME_PATH . 'common~runtime.php') &&
                        // unlink(RUNTIME_PATH . 'common~runtime.php');
                        // // 删除目录
                        // Dir::del(RUNTIME_PATH . 'cache');
                        //Dir::del(RUNTIME_PATH . 'temp');
                        //Dir::del(RUNTIME_PATH . 'data');
                        //Dir::del(RUNTIME_PATH . 'logs');
                        Dir::del(RUNTIME_PATH . 'temp');
                        $msg = '其它项更新成功';
                        break;
                    default:

                        # code...
                        break;
                }
                return $this->success($msg);
            } else {
                $msg = '缓存更新成功...';
                $this->app->cache->set('action', null);

                // 日志记录
                //action_log(1);
                return $this->error($msg);
            }

        } else {
            return $this->menusView();
        }

    }
}
