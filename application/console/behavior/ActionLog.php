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
 * @filename  ActionLog.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 11:37:08
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\behavior;

use think\facade\App;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Request;

class ActionLog
{

    public function run($param)
    {
        $this->actionLog();
    }

    /**
     * { actionLog 行为记录方法}
     * @Author   SpringYang
     * @DateTime 2017-10-24T11:47:42+0800
     * @param    [numb]                   $id [description]
     * @return   [type]                       [description]
     */
    private function actionLog($id = null)
    {

        // if (!Config::get('action_log') && !session('mid')) {
        //     return true;
        // }

        // 特殊情况处理
        if (strtolower(Request::module()) == 'start1') {
            return true;
        }

        $instantiationController = Cache::get('instantiation_controller');

        if (!in_array(strtolower(toUnderline(Request::controller())), $instantiationController)) {
            return false;
        }

        $controller = Request::controller(); // 取得控制器名称
        $action     = strtolower(Request::action()); // 取得方法名称
        $model      = App::model($controller); // 实例化控制器
        $pk         = $model->getPk(); // 取得主键字段名

        // 有 id 键是更新，没有是新增
        // if (input('?param.' . $pk)) {
        if (Request::has($pk)) {
            $id = deauthcode(Request::param($pk)); // id解密
            if ($action == 'update') {
                $action = 'edit';
            }
        } else {
            $id = db($controller)->getLastInsID();
            if ($action == 'update') {
                $action = 'add';
            }
        }

        switch (strtolower($controller . '_' . $action)) {
            case 'config_groupupdate':
                $id = -1;
                break;

            default:
                # code...
                break;
        }

        $record_id = $id;

        if (Request::isGet() || Request::isPut() || Request::isDelete()) {
            $this->actionLogRun($record_id, $action); // 记录日志
        }

        // get 的特殊情况
        if (Request::isGet()) {
            $getRunLog        = ['actionlog_del']; // 特殊情况列表
            $getRunLog        = Config::get('actionlog_list');
            $controllerAction = strtolower($controller . '_' . $action); // 组合控制器和方法

            if (in_array($controllerAction, $getRunLog)) {
                $this->actionLogRun($record_id, $action); // 记录日志
            }
        }

    }

    /**
     * { actionLogRun 行为记录执行}
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-24T15:32:17+0800
     * @param    [type]                   $record_id [description]
     * @param    [type]                   $action    [description]
     * @return   [type]                              [description]
     */
    public function actionLogRun($record_id = null, $action = null)
    {
        model('ActionLog')->actionLogRun($record_id, $action);
    }
}
