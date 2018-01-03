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

class Cache extends Base
{
    public function initialize()
    {
        parent::initialize();

    }

    /**
     * [ cache 更新缓存 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-30T15:27:14+0800
     * @return   [type]                   [description]
     */
    public function cache()
    {
        $runTimePath = Env::get('runtime_path'); // 运行目录

        if ($this->app->request->isAjax()) {

            if (!$this->app->cache->has('action')) {
                $action = $this->app->request->param('action/a');
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
                        $this->app->model('authRule')->updateCache();
                        $msg = '规则表缓存更新成功...';
                        break;
                    case 'ueditor':
                        $ueditorPath = './data/ueditor/';

                        Dir::del($ueditorPath . 'file');
                        Dir::del($ueditorPath . 'images');
                        Dir::del($ueditorPath . 'video');

                        Dir::create($ueditorPath . 'file');
                        Dir::create($ueditorPath . 'images');
                        Dir::create($ueditorPath . 'video');
                        $msg = 'ueditor 暂存目录更新成功...';
                        break;
                    case 'temp':
                        $tempPath = '../data/temp';
                        Dir::del($tempPath);
                        Dir::create($tempPath);
                        $msg = '临时目录更新成功...';
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
                        //Dir::del($runTimePath . 'cache');
                        //Dir::create($runTimePath . 'cache');
                        Dir::del($runTimePath . 'temp');
                        Dir::create($runTimePath . 'temp');
                        $msg = '其它项更新成功';
                        break;
                    default:

                        # code...
                        break;
                }

                $data['type'] = $current;
                return $this->success($msg, '', $data);
            } else {
                $msg = '缓存更新成功...';
                $this->app->cache->rm('action'); // 删除 action 缓存

                // 日志记录
                //action_log(1);
                return $this->error($msg);
            }

        } else {
            return $this->menusView();
        }

    }

    public function resetcache()
    {
        $this->app->cache->set('action', null);
        return $this->success('重置成功');
    }
}
