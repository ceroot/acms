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
        if (!is_null($username) && !is_null($password)) {
            $field = 'id,username,password,salt,status,times,create_time,update_time';
            $map   = [
                ['username|email|mobile', '=', $username],
            ];

            $user = $this->UcenterMember->where($map)->field($field)->find();
            $user = $user->getData();

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
            // return $user;
            if ($user['password'] != $this->encryptPassword($password, $user['salt'])) {
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
        Session::set('user_auth_sign', $this->dataAuthSign($auth));

        $this->updateLogin($user['id']); // 更新用户登录信息
    }

    /**
     * [ isLogin 检测用户是否登录 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-06T12:17:10+0800
     * @return   integer                  [0-未登录，大于0-当前登录用户ID]
     */
    public function isLogin()
    {
        $user = Session::get('user_auth');
        if (empty($user)) {
            return 0;
        } else {
            $status = $this->getUserInfo($user['id'], 'status');
            // 查询用户是否存在及用户状态
            if (!$status) {
                return 0;
            } else {
                return Session::get('user_auth_sign') == $this->dataAuthSign($user) ? $user['id'] : 0;
            }
        }
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

    /**
     * [ modifyPassword 设置密码（修改密码） ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-02T15:38:30+0800
     * @param    integer                  $id       [用户 id]
     * @param    string                   $password [用户密码]
     * @return   boolean                            [返回布尔型]
     */
    public function modifyPassword($id, $password)
    {
        // $salt = $this->UcenterMember->getFieldById($id, 'salt');
        $data             = $this->UcenterMember->get($id);
        $data['password'] = $this->encryptPassword($password, $data['salt']);
        $status           = $data->save($data);
        return $status ? true : false;
    }

    /**
     * [ function_name function_description ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-02T16:13:32+0800
     * @param    array                    $data [用户数据]
     * @return   [type]                   [description]
     */
    public function modifyInfo($data)
    {

    }

    /**
     * [ getUserInfo 取得用户信息 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-06T11:36:42+0800
     * @param    intger                   $uid   [用户id]
     * @param    string                   $field [表字段]
     * @return   string & array                  [返回字符（单独取得单个信息）或者数组（用户全部信息）]
     */
    public function getUserInfo($uid = null, $field = null)
    {

        if (!($uid && is_numeric($uid))) {
            return false;
        }

        if (is_null($field)) {
            $info = $this->UcenterMember->find($uid);
        } else {
            $info = $this->UcenterMember->getFieldById($uid, $field);
        }
        return $info;
    }

    /**
     * [ userStatus 取得用户状态 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-06T11:55:01+0800
     * @param    intger                    $uid [用户id]
     * @return   boolear                        [0-禁用，1-正常]
     */
    public function userStatus($uid)
    {
        if ($uid && is_numeric($uid)) {
            return $this->UcenterMember->getFieldById($uid, 'status');
        }
    }

    /**
     * [ loginout 退出登录 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-03T15:03:35+0800
     * @return   [type]                   [description]
     */
    public function loginout()
    {
        $this->clearSession();
    }

    /**
     * [ clearSession 清除用户登录 session ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-06T13:40:53+0800
     * @return   [type]                   [description]
     */
    public function clearSession()
    {
        Session::pull('user_auth');
        Session::pull('user_auth_sign');
    }

    /**
     * [ encryptPassword 密码加密 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-24T17:35:25+0800
     * @param    string                   $password [description]
     * @param    string                   $salt     [description]
     * @return   string                             [description]
     */

    public function encryptPassword($password, $salt)
    {
        return '' === $password ? '' : md5(sha1($password) . sha1($salt));
    }

    /**
     * dataAuthSign 数据签名认证
     * @param  array  $data 被认证的数据
     * @return string       签名
     * @author
     */
    private function dataAuthSign($data)
    {
        //数据类型检测
        if (!is_array($data)) {
            $data = (array) $data;
        }
        ksort($data); //排序
        $code = http_build_query($data); //url编码并生成query字符串
        $sign = sha1($code); //生成签名
        return $sign;
    }

}
