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
 * @filename  UserInfo.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-25 14:52:12
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\model;

use app\common\model\Extend;
use think\facade\Session;

class Manager extends Extend
{
    protected $update = ['login_time'];

    /**
     * [ setLoginTimeAttr 登录时间自动化 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T11:26:10+0800
     */
    public function setLoginTimeAttr()
    {
        return time();
    }

    /**
     * [ getLoginTimeAttr 自动处理登录时间格式化 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T11:26:16+0800
     * @param    integer                   $value [时间数字]
     * @return   string                           [时间格式 0000-00-00 00:00:00]
     */
    public function getLoginTimeAttr($value)
    {
        return time_format($value);
    }

    /**
     * [ login 管理用户登录 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T10:25:25+0800
     * @param    integer                   $id [用户 id]
     * @return   array                         [返回管理用户信息]
     */
    public function login($uid)
    {
        if (!$uid || !is_numeric($uid)) {
            $this->error = '参数错误';
            return false;
        }

        $manager = self::getByUid($uid); // 查询管理用户
        $manager = $manager->getData(); // 取得原数据

        if (!$manager) {
            $this->error = '管理用户不存在';
            return false;
        }

        if ($manager['status'] == 0) {
            $this->error = '管理用户禁用，请联系管理员';
            return false;
        }
        return $manager;
    }

    /**
     * [ autoLogin 管理用户自动登录 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T10:37:26+0800
     * @param    array                    $manager [管理用户信息]
     * @return   [type]                            [description]
     */
    public function autoLogin($manager)
    {
        Session::set('manager_id', $manager['id']);
    }
}
