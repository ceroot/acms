<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 http://beneng.com All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 * @filename  Base.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-03-03 15:19:23
 * @site      http://www.benweng.com
 */
namespace app\console\controller;

use app\facade\User;
use think\Controller;
use think\facade\App;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

class Start extends Controller
{
    protected $model;
    /**
     * [initialize 控制器初始化]
     */
    public function initialize()
    {
        $this->model = App::model('manager');
    }
    /**
     * [ index 登录页面 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T15:07:32+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        // dump(input('backurl'));die;
        // session(null);
        if (Request::isPost()) {
            /******接收数据******/
            $username = Request::param('username'); // 用户名
            $password = Request::param('password'); // 密码
            $code     = Request::param('verify'); // 验证码
            // 设置错误 session
            if (!Session::has('error_num')) {
                Session::set('error_num', 0);
            }
            // 检测错误次数
            $error_num = Session::get('error_num');
            // 验证码验不为空
            if ($error_num > 3) {
                if (!$code) {
                    $error = '请输入验证码';
                    $this->error($error, '', array('error_num' => $error_num, 'verifyhtml' => $this->verifyhtml()));
                }
                // 验证码是否相等
                if (!captcha_check($code)) {
                    $error = '验证码输入错误';
                    $this->error($error, '', array('error_num' => $error_num, 'verifyhtml' => $this->verifyhtml()));
                }
            }
            $user = User::login($username, $password); // 用户登录验证
            // 验证不成功时
            if (!$user) {
                Session::set('error_num', $error_num + 1); // 错误次数加 1
                $this->error(User::getError(), '', array('error_num' => $error_num, 'verifyhtml' => $this->verifyhtml()));
            }
            $manager = $this->model->login($user->id); // 管理员用户验证并返回管理用户信息
            $manager || $this->error($this->model->getError(), '', array('error_num' => $error_num));
            User::autoLogin($user); // 用户自动登录
            $this->model->autoLogin($manager); // 管理用户自动登录
            App::model('ActionLog')->actionLogRun($user, 'login', 'manager', $user); // 记录登录日志
            Session::pull('error_num'); // 登录成功，清除登录错误次数记录，释放 sesseion
            $time     = date('YmdHis');
            $authcode = authcode($time);
            $this->success('登录成功', url('console/index/index?time=' . $time . '&authcode=' . $authcode), ['error_num' => 0]);
        } else {
            $this->assign('verifyhtml', $this->verifyhtml());
            return $this->fetch();
        }
    }
    public function test($id = null)
    {
        $test = null;
        $dd   = Config::get('checklogin.not_login_action') ?: [];
        dump($dd);
        $backurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        dump(getbackurl(false));
        Session::pull('manager_id');
    }
    /**
     * [ verifyhtml 登录页面验证码 html ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T16:14:50+0800
     * @return   html                   [返回 html]
     */
    public function verifyhtml()
    {
        // return 132;
        $html = '<div class="layui-form-item captcha-area">' .
        '<div class="layui-form-item" style="margin-left: 0;">' .
        '<input type="text" name="verify" id="verify" lay-verify="required" placeholder="验证码" class="layui-input"><img src="' . url('verify') . '" alt="验证码"></div>' .
            '</div>';
        return $html;
    }
    /**
     * [ verify 验证码 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-24T17:59:31+0800
     * @return   img                   [返回图片]
     */
    public function verify()
    {
        $captcha = new \think\captcha\Captcha();
        return $captcha->entry();
    }
    public function indd()
    {
        // 判断session完成标记是否存在
        if (session('?complete')) {
            // 删除session
            session('complete', null);
            return '重定向完成，回到原点!';
        } else {
            // 记住当前地址并重定向
            return redirect('hello')
                ->with('name', 'thinkphp')
                ->remember();
        }
    }
    public function hello()
    {
        dump(redirect()->restore());
        $name = session('name');
        return 'hello,' . $name . '! <br/><a href="/console/start/restore">点击回到来源地址</a>';
    }
    public function restore()
    {
        // 设置session标记完成
        session('complete', true);
        // 跳回之前的来源地址
        return redirect()->restore();
    }
}
