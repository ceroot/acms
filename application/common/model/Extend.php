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
 * @filename  Extend.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 10:58:09
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use app\common\traits\Models;
use think\Model;

class Extend extends Model
{

    use Models; // 模型扩展

    // 自动完成
    protected $auto   = [];
    protected $insert = ['create_uid', 'create_time', 'create_ip'];
    protected $update = ['update_uid', 'update_time', 'update_ip'];

    // protected $updateTime = false; // 关闭更新时间的自动写入

    /**
     * { init 模型初始化}
     * @Author   SpringYang
     * @DateTime 2017-10-23T11:03:36+0800
     * @return   [type]                   [description]
     */
    protected static function init()
    {

    }

    /**
     * [ setCreateIpAttr 设置创建 ip 为整型 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T15:59:11+0800
     */
    public function setCreateIpAttr()
    {
        return ip2int();
    }

    /**
     * [ setUpdateIpAttr 设置更新 ip 为整型 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T15:57:42+0800
     */
    public function setUpdateIpAttr()
    {
        return ip2int();
    }

    /**
     * [ getCreateIpAttr 取得创建 ip 时转换为 ip 格式 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T15:59:48+0800
     * @param    [type]                   $value [description]
     * @return   [type]                          [description]
     */
    public function getCreateIpAttr($value)
    {
        return long2ip($value);
    }

    /**
     * [ getUpdateIpAttr 取得更新 ip 时转换为 ip 格式 ]
     * @Author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-25T16:00:11+0800
     * @param    [type]                   $value [description]
     * @return   [type]                          [description]
     */
    public function getUpdateIpAttr($value)
    {
        return long2ip($value);
    }

}
