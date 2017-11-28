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
 * @date      2017-10-24 15:25:49
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\logic;

use think\facade\Log;
use think\facade\Request;
use think\facade\Session;
use think\Model;

class ActionLog extends Model
{

    /**
     * [actionLogRun 行为记录逻辑]
     * @param  string   $action     [行为标识]
     * @param  string   $model      [触发行为的模型名]
     * @param  int      $record_id  [触发行为的记录id]
     * @param  int      $user_id    [执行行为的用户id]
     * @return Array
     * @author SpringYang <ceroot@163.com>
     */
    public function actionLogRun($record_id = null, $action = null, $model = null, $user_id = null)
    {

        // 参数检查
        if (is_null($record_id)) {
            return '参数不能为空';
        }

        if (empty($model)) {
            $model = Request::controller();
        }

        if (empty($action)) {
            $action = Request::action();

        }

        if (empty($user_id)) {
            if (Session::has('manager_id')) {
                $user_id = Session::get('manager_id');
            }
        }

        $action = $model . '_' . $action;
        $action = strtolower($action); // 小写转换

        // 查询行为,判断是否执行
        $action_info = db('action')->getByName($action);

        if (!$action_info) {
            return false;
        }
        //return $action;
        if ($action_info['status'] != 1) {
            return '该行为被禁用或删除';
        }

        // 取得日志规则
        $action_log = $action_info['log'];

        // 解析日志规则,生成日志备注
        if (!empty($action_log)) {

            if (preg_match_all('/\[(\S+?)\]/', $action_log, $match)) {
                $log['user_id']  = $user_id;
                $log['record']   = $record_id;
                $log['model']    = $model;
                $log['time']     = time();
                $log['table_id'] = $model . '|' . $record_id;
                $log['type']     = Session::get('log_text');
                $log['data']     = array('user_id' => $user_id, 'model' => $model, 'record' => $record_id, 'time' => time());

                foreach ($match[1] as $key => $value) {
                    //dump($value);
                    $param = explode('|', $value);

                    if (isset($param[1])) {
                        $replace[] = call_user_func($param[1], $log[$param[0]]);

                    } else {
                        $replace[] = $log[$param[0]];
                    }

                }
                // return $replace;
                $data['remark'] = str_replace($match[0], $replace, $action_log);
            } else {
                $data['remark'] = $action_log;
            }
        } else {
            // 未定义日志规则，记录操作url
            $data['remark'] = '操作url：' . $_SERVER['REQUEST_URI'];
        }

        // 数据组合
        $data['action_id'] = $action_info['id'];
        $data['user_id']   = $user_id;
        $data['model']     = $model;
        $data['method']    = Request::method();
        $data['record_id'] = $record_id;
        $data['url']       = Request::url();
        $data['device']    = get_visit_source();

        // $data['create_time'] = time();
        // $data['create_ip']   = ip2int();

        return $data;
        // db('ActionLog')->insert($data);
    }
}
