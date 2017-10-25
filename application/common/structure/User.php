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
 * @date      2017-10-25 14:00:19
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\structure;

use app\common\traits\Models;
use think\facade\App;
use think\facade\Log;
use think\facade\Session;

class User
{
    use Models;

    private $UcenterMember;

    /**
     * [ __construct 初始化 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T14:13:18+0800
     */
    public function __construct()
    {
        $this->UcenterMember = App::model('UcenterMember'); // 实例化用户模型
    }

    /**
     * [ login 用户登录认证 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-24T17:22:29+0800
     * @param    string                   $username [用户名]
     * @param    string                   $password [用户密码]
     * @param    integer                  $type     [用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）]
     * @return   array || string                    [登录成功-用户信息，登录失败-错误信息]
     */
    public function login($username, $password, $type = 1)
    {
        // $map['username|email|mobile'] = $username;
        if (!is_null($username) && !is_null($password)) {
            $field = 'id,username,password,salt,status,times,create_time,update_time';
            $user  = $this->UcenterMember->field($field)->getByUsername($username);

            if (!$user) {
                $this->error = '用户不存在';
                Log::record('[登录错误记录 ]：' . $this->error);
                return false;
            }

            if (!$user['status']) {
                $this->error = '用户锁定中，请联系管理员';
                Log::record('[ 登录错误记录 ]：' . $this->error);
                return false;
            }

            if ($user['password'] != encrypt_password($password, $user['salt'])) {
                $this->error = '密码错误';
                Log::record('[登录错误记录 ]：' . $this->error);
                return false;
            }
            return $user; // 返回用户信息
        }
    }

    /**
     * [ autoLogin 用户自动登录处理 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T11:56:15+0800
     * @param    array                    $user [用户信息]
     * @return   [type]                         [description]
     */
    public function autoLogin($user)
    {
        $auth = [
            'id'         => $user['id'],
            'username'   => $user['username'],
            'login_time' => $user['update_time'],
        ];

        Session::set('user_auth', $auth);
        Session::set('user_auth_sign', data_auth_sign($auth));

        $this->updateLogin($user['id']); // 更新用户登录信息
    }

    /**
     * [ updateLogin 更新用户登录信息 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T15:21:02+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function updateLogin($id)
    {
        $data['id']         = $id;
        $data['login_time'] = time();
        $data['login_ip']   = ip2int();
        $data['times']      = ['exp', 'times+1'];

        $this->UcenterMember->update($data);
    }

}
