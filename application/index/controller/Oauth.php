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
 * @filename  Oauth.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-12-07 13:09:29
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\index\controller;

use app\common\controller\Extend;
use app\index\event\TypeEvent;
use lt\ThinkSDK\ThinkOauth;

class Oauth extends Extend
{
    public function index()
    {
        dump('Oauth');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    //登录地址
    public function login($type = null)
    {
        empty($type) && $this->error('参数错误');
        //加载ThinkOauth类并实例化一个对象
        $sns = ThinkOauth::getInstance($type);
        //跳转到授权页面
        $this->redirect($sns->getRequestCodeURL());
    }

    //授权回调地址
    public function callback($type = null, $code = null)
    {
        //支付宝code
        if ('alipay' == $type) {
            $code = $_GET['auth_code'];
        }
        (empty($type) || empty($code)) && $this->error('参数错误');

        //加载ThinkOauth类并实例化一个对象
        $sns = ThinkOauth::getInstance($type);

        //腾讯微博需传递的额外参数
        $extend = null;
        if ($type == 'tencent') {
            $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
        }

        //请妥善保管这里获取到的Token信息，方便以后API调用
        //调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
        //如： $qq = ThinkOauth::getInstance('qq', $token);
        $token = $sns->getAccessToken($code, $extend);

        //获取当前登录用户信息
        if (is_array($token)) {
            $TypeEven = new TypeEvent();

            $result = $TypeEven->$type($token);

            // $result = A('Type', 'Event')->$type($token);

            echo ("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
            echo ("授权信息为：<br>");
            dump($token);
            echo ("当前登录用户信息为：<br>");
            dump($result);

            // if ($result === true) {

            //     $this->success("恭喜！使用{$type}用户登录成功！", 'center/index');

            //     //$this->redirect('center/index');
            // } else {
            //     $this->error($result);
            // }
        }
    }
}
