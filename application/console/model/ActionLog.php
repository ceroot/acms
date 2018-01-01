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
 * @filename  ActionLog.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 15:23:39
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\model;

use app\common\model\Extend;
use think\facade\App;
use think\model\concern\SoftDelete;

class ActionLog extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * { actionLogRun 行为记录写入}
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-24T15:24:39+0800
     * @param  string   $action     [行为标识]
     * @param  string   $model      [触发行为的模型名]
     * @param  int      $record_id  [触发行为的记录id]
     * @param  int      $user_id    [执行行为的用户id]
     * @param  string   $actioninfo [记录信息]
     * @return boolean
     */
    public function actionLogRun($record_id = null, $action = null, $model = null, $user_id = null, $actioninfo = null)
    {
        $data = App::model('ActionLog', 'logic')->actionLogRun($record_id, $action, $model, $user_id, $actioninfo);
        if (is_array($data)) {
            if ($this->data($data)->save()) {
                return true;
            }
        }
    }
}
