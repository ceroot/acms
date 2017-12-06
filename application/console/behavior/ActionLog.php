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
use think\facade\Config;
use think\facade\Log;
use think\facade\Session;

class ActionLog
{
    public function run($params)
    {
        // 先判断要不要执行
        if (Config::get('action_log') && Session::get('manager_id')) {

            $this->initialization();

            array_key_exists('model', $params) || $params['model']           = null;
            array_key_exists('action', $params) || $params['action']         = null;
            array_key_exists('record_id', $params) || $params['record_id']   = 0;
            array_key_exists('user_id', $params) || $params['user_id']       = 0;
            array_key_exists('actioninfo', $params) || $params['actioninfo'] = null;

            return $this->actionLog($record_id = $params['record_id'], $action = $params['action'], $model = $params['model'], $user_id = $params['user_id'], $actioninfo = $params['actioninfo']);

        }

    }

    /**
     * [ initialization 初始化 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-26T11:00:31+0800
     * @return   [type]                   [description]
     */
    private function initialization()
    {

    }

    /**
     * { actionLog 行为记录方法}
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-24T11:47:42+0800
     * @param    integer                   $id [description]
     * @return   [type]                        [description]
     */
    private function actionLog($record_id = null, $action = null, $model = null, $user_id = null, $actioninfo = null)
    {
        $result = App::model('ActionLog')->actionLogRun($record_id, $action, $model, $user_id, $actioninfo);
        if ($result) {
            Log::record('[ 行为日志 ]：行为记录执行成功');
        } else {
            Log::record('[ 行为日志 ]：行为记录执行失败');
        };
    }

}
