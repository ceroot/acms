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
     * @Author   SpringYang
     * @DateTime 2017-10-24T12:00:16+0800
     * @param    integer                  $isArray [description]
     * @return   [type]                            [description]
     */
    public function getAll($isArray = 0)
    {

        $cache = Cache::get('authrule');

        if ($isArray) {
            return Data::channelLevel($cache, 0, '', 'id', 'pid');
        } else {
            return Data::tree($cache, 'title', 'id', 'pid');

        }
    }

    public function updateCache()
    {
        App::model('AuthRule', 'logic');
    }

}
