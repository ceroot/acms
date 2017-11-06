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
 * @filename  WebLog.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 10:29:05
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\behavior;

use app\common\model\WebLog as WebLogModel;
use think\facade\App;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;

class WebLog
{
    /**
     * { function_name function_description}
     * @Author   SpringYang
     * @DateTime 2017-10-23T10:48:09+0800
     * @param    [type]                   $param [description]
     * @param    [type]                   $dd    [description]
     * @return   [type]                          [description]
     */
    public function run($param)
    {
        // Log::record("[ 系统配置 ]：初始化成功");
        $this->webLog();

    }

    /**
     * { function_name function_description}
     * @Author   SpringYang
     * @DateTime 2017-10-23T10:48:12+0800
     * @return   [type]                   [description]
     */
    private function webLog()
    {

        // 网站日志记录开关判断
        if (!Config::get('weblog.status')) {
            return true;
        }

        // 不需要记录的请求方式 string
        $not_log_method_default = [];
        $not_log_method_config  = Config::get('weblog.not_log_method') ?: [];
        $not_log_method         = array_merge($not_log_method_default, $not_log_method_config);

        // 不需要记录的模块 'module'
        $not_log_module_default = [];
        $not_log_module_config  = Config::get('weblog.not_log_module') ?: [];
        $not_log_module         = array_merge($not_log_module_default, $not_log_module_config);

        // 不需要记录的控制器 'module/controller'
        $not_log_controller_default = [];
        $not_log_controller_config  = Config::get('weblog.not_log_controller') ?: [];
        $not_log_controller         = array_merge($not_log_controller_default, $not_log_controller_config);

        // 不需要记录的方法 'module/controller/action'
        $not_log_action_default = [];
        $not_log_action_config  = Config::get('weblog.not_log_action') ?: [];
        $not_log_action         = array_merge($not_log_action_default, $not_log_action_config);

        // 不需要记录的方法（特殊情况） 'action'
        $not_log_action_exc_default = [
            'test', // 测试方法
            'showverify', // 验证码
            'setcollapsed', // 侧边栏
        ];
        $not_log_action_exc_config = Config::get('weblog.not_log_action_exc') ?: []; // 取得配置
        $not_log_action_exc        = array_merge($not_log_action_exc_default, $not_log_action_exc_config);

        if (
            (Config::get('app_debug') && Request::param('notlog') == 1) || // 当开发模式开启并且 param 参数 notlog 为 1 时不记录
            in_array(strtolower(Request::action()), $not_log_action_exc) || // 一些特殊方法的处理
            in_array(strtolower(Request::method()), $not_log_method) ||
            in_array(strtolower(Request::module()), $not_log_module) ||
            in_array(strtolower(Request::module() . '/' . Request::controller()), $not_log_controller) ||
            in_array(strtolower(Request::module() . '/' . Request::controller() . '/' . Request::action()), $not_log_action)
        ) {
            Log::record("[ 网站日志记录 ]：此访问不记录网站日志");
            return true;
        }

        // 不需要记录数据的方法 'module/controller/action'
        $not_log_data = Config::get('weblog.not_log_data') ?: [];

        // 数据处理
        if (in_array(strtolower(Request::module() . '/' . Request::controller() . '/' . Request::action()), $not_log_data)) {
            $tempData = '';
        } else {
            $paramData = Request::param(); // 取得提交数据
            $tempData  = [];
            foreach ($paramData as $k => $v) {
                if (is_string($v) && isset($v{50})) {
                    $v = mb_substr($v, 0, 50);
                }
                $tempData[$k] = $v;
            }
            $paramData = $tempData;
        }

        // 写入数据组合
        $data = [
            'uid'        => session('mid') ?: 0,
            'os'         => getOs(),
            'browser'    => getBroswer(),
            'url'        => Request::url(),
            'module'     => Request::module(),
            'controller' => Request::controller(),
            'action'     => Request::action(),
            'method'     => Request::method(),
            'data'       => serialize($paramData),
            'device'     => get_visit_source(),
        ];

        // App::model('WebLog')->create($data);
        $model = new WebLogModel;
        if ($model->create($data)) {
            Log::record("[ 网站日志记录 ]：网站日志数据记录成功");
        } else {
            Log::record("[ 网站日志记录 ]：网站日志数据记录失败");
        };

    }

}
