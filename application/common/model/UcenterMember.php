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
 * @filename  UcenterMember.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-24 16:18:06
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use app\common\model\Extend;
use think\model\concern\SoftDelete;

class UcenterMember extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * [ getLoginTimeAttr 取得登录时间格式 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T15:54:52+0800
     * @param    integer                   $value [description]
     * @return   date                             [返回时间格式]
     */
    public function getLoginTimeAttr($value)
    {
        return time_format($value);
    }

    /**
     * [ getLoginIpAttr 取得登录 IP 格式 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T15:55:40+0800
     * @param    integer                   $value [description]
     * @return   date                             [返回 IP 格式]
     */
    public function getLoginIpAttr($value)
    {
        return long2ip($value);
    }
}
