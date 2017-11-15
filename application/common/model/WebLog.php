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
 * @date      2017-10-23 10:56:57
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\model;

use app\common\model\Extend;
use think\model\concern\SoftDelete;

class WebLog extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function getFromAttr($value)
    {
        return '贵州';
    }

}
