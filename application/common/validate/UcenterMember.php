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
 * @date      2017-11-02 10:48:24
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\validate;

use think\Validate;

class UcenterMember extends Validate
{
    protected $rule = [
        'username'         => 'require|min:2|unique:UcenterMember',
        'password'         => 'require|min:6|max:18|confirm',
        'password_confirm' => 'require',
        'nickname'         => 'unique:UcenterMember',
        'email'            => 'email|unique:UcenterMember',
        'mobile'           => 'mobile|unique:UcenterMember',
    ];

    protected $message = [
        'username.require'         => '用户名必须',
        'username.unique'          => '用户名已经存在',
        'username.min'             => '用户名长大要大于2',
        'password.require'         => '密码必填',
        'password.min'             => '密码长度必须大于等于6',
        'password.max'             => '密码长度过长',
        'password.confirm'         => '确认密码不正确',
        'password_confirm.require' => '确认密码必须',
        // 'nickname.require'   => '昵称必填',
        'nickname.unique'          => '昵称已经存在',
        'email'                    => '邮箱格式不正确',
        'email.unique'             => '邮箱已经存在，请换一个',
        'mobile'                   => '手机格式不正确',
        'mobile.unique'            => '手机已经存在，请换一个',
    ];

    protected $scene = [
        'add'      => ['username', 'password'],
        'edit'     => ['username', 'nickname', 'email', 'mobile'],
        'password' => ['password', 'password_confirm'],
        'info'     => ['nickname', 'email', 'mobile'],
    ];
}
