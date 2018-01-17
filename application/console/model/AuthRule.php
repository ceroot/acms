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
 * @filename  ${saved_filename}
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 11:56:13
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\model;

use app\common\model\Extend;
use data\Data;
use think\facade\App;
use think\facade\Cache;

class AuthRule extends Extend
{
    /**
     * { getAll 取得处理后的全部数据}
     * @author   SpringYang
     * @email    ceroot@163.com
     * @DateTime 2017-10-24T12:00:16+0800
     * @param    integer                  $isArray [description]
     * @return   [type]                            [description]
     */
    public function getAll($isArray = 0)
    {
        $cache  = Cache::get('authrule');
        $redata = $isArray ? Date::channelLevel($cache, 0, '', 'id', 'pid') : Data::tree($cache, 'title', 'id', 'pid');
        return $redata;
    }

    /**
     * [ updateCache 更新缓存 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:05:28+0800
     * @return   [type]                   [description]
     */
    public function updateCache()
    {
        App::model('AuthRule', 'logic')->updateCache();
    }

    /**
     * [ del 删除规则 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:05:52+0800
     * @param    integer                  $id [规则 id]
     * @return   [type]                       [description]
     */
    public function del($id)
    {
        $count = $this::where('pid', $id)->count();
        if ($count) {
            $this->error = '请先删除子规则';
            return false;
        }
        $status = $this::destroy($id);
        if ($status) {
            $this->updateCache();
            return true;
        } else {
            $this->error = '根据条件没有数据可进行删除';
            return false;
        }
    }

}
