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
use QL\QueryList;
use think\Controller;
use think\facade\App;
use think\facade\Hook;
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
            $uid  = $user['id'];

            // 验证不成功时
            if (!$user) {
                Session::set('error_num', $error_num + 1); // 错误次数加 1
                return $this->error(User::getError(), '', array('error_num' => $error_num, 'verifyhtml' => $this->verifyhtml()));
            }

            $manager = $this->model->login($uid); // 管理员用户验证并返回管理用户信息
            $manager || $this->error($this->model->getError(), '', array('error_num' => $error_num)); // 用户不存在返回提示

            User::autoLogin($user); // 用户自动登录
            $this->model->autoLogin($manager); // 管理用户自动登录
            Hook::listen('action_log', ['action' => 'login', 'record_id' => $uid, 'model' => 'manager']); // 行为日志记录
            Session::pull('error_num'); // 登录成功，清除登录错误次数记录，释放 sesseion

            $time     = date('YmdHis');
            $authcode = authcode($time);
            return $this->success('登录成功', url('console/index/index?time=' . $time . '&authcode=' . $authcode), ['error_num' => 0]);
        } else {
            $this->assign('verifyhtml', $this->verifyhtml());
            return $this->fetch();
        }
    }
    public function test($id = null)
    {
        // dump(is_dir('../data/temp/'));
        // dump(file_exists('../data/temp/'));
        // make_dir('./data/temp/dd');
        // die;
        $ddd = get_keywords('中国  共  产   党你 好贵阳黄  平吃饭睡觉打   灰魂牵梦萦  朝秦暮楚  夺需 要硒鼓');
        dump($ddd);

    }
    public function vue()
    {
        return $this->fetch();
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

    public function logout()
    {
        $mid = Session::get('user_auth.id');
        if (!$mid) {
            $this->redirect('console/start/index');
        }

        Hook::listen('action_log', ['action' => 'logout', 'record_id' => $mid, 'model' => 'manager']); // 行为日志记录
        User::loginout(); // 清除用户 session
        Session::pull('manager_id'); // 清除管理用户 session
        $backurl = Request::param('backurl');
        //$hashT   = session('hash');
        //$backurl = $backurl . $hashT;

        $backurl  = rawurlencode($backurl); //encodeURIComponent
        $loginurl = url('console/start/index?time=' . time()) . '?backurl=' . $backurl;

        return $this->success('注销成功', $loginurl);
    }

    public function ttt()
    {
        $data = QueryList::get('http://www.163gz.com/js/163.html')->rules([
            'link' => ['.STYLE4>a', 'href', '', function ($content) {
                //利用回调函数补全相对链接
                $baseUrl = 'http://cms.querylist.cc';
                return $content;
            }],
            'text' => ['.STYLE4>a', 'text'],
        ])->query()->getData();

        // $data = QueryList::rules([
        //     'txt' => ['a', 'text'],
        // ])->get('https://top.etao.com')->encoding('UTF-8', 'GB2312')->query()->getData();
        //打印结果
        $temp = '';
        foreach ($data->all() as $value) {
            # code...
            $temp .= $value['text'];

        }
        // dump($temp);

        // die;
        $path    = "C:\\Users\\ceroo\\Desktop\\test\\one.txt";
        $content = "one for all";
        file_put_contents($path, $temp);
        if (file_exists($path)) {echo "ok";} else {echo "ng";}

    }

    public function te()
    {
        // $data = QueryList::get('http://cms.querylist.cc/bizhi/460.html')->find('img')->attrs('src');
        //打印结果
        // dump($data->all());

        // $html = file_get_contents('http://www.163gz.com/js/163.html');
        // //然后可以把页面源码或者HTML片段传给QueryList
        // $data = QueryList::html($html)->rules([ //设置采集规则
        //     // 采集所有a标签的href属性
        //     'link' => ['a', 'href'],
        //     // 采集所有a标签的文本内容
        //     'text' => ['a', 'text'],
        // ])->query()->getData();

        // $data = QueryList::get('http://www.163gz.com/js/163.html')->rules([
        //     'link' => ['.STYLE4>a', 'href', '', function ($content) {
        //         //利用回调函数补全相对链接
        //         $baseUrl = 'http://cms.querylist.cc';
        //         return $content;
        //     }],
        //     'text' => ['.STYLE4>a', 'text'],
        // ])->query()->encoding('GB2312')->getData();

        // $data = QueryList::rules([
        //     'text' => ['#zoom', 'text'],
        // ])->get('http://www.163gz.com/gzzp8/zkxx/20171108/195941.shtml')->encoding('UTF-8', 'GB2312')->query()->getData();
        //打印结果
        $data = QueryList::get('http://www.163gz.com/gzzp8/zkxx/20171108/195941.shtml')->rules([
            'title' => ['#zoom h3', 'text'],
            'text'  => ['#zoom', 'text', 'p', function ($content) {
                $content = strtolower($content);
                $pattern = "/<p[^>]*>([^\<|\>]*)<\/p>/is";
                preg_match_all($pattern, $content, $Html);
                // dump($Html[0]);
                $temp = '';
                foreach ($Html[0] as $value) {
                    preg_match($pattern, $value, $p1);
                    if (strpos($value, 'text-align: right')) {
                        $temp .= '<p style="text-align:right;">' . $p1[1] . '</p>';
                    } else {
                        $temp .= '<p>' . $p1[1] . '</p>';
                    }
                }
                return $temp;
            }],
        ])->query()->getData();

        $ddd = $data->all();
        $ddd = $ddd[0];
        // dump($ddd['text']);
        // die;
        $path = "C:\\Users\\veroo\\Desktop\\test\\" . time() . ".txt";
        file_put_contents($path, $ddd['text']);
        if (file_exists($path)) {
            echo "ok";
        } else {
            echo "ng";
        }

        // dump($data->all());
    }

    public function t2()
    {
        $content = '惠水县关于接转2014年“特岗教师”为正式教师的公示
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　根据《省教育厅省财政厅 省人力资源和社会保障厅 省机构编制委员会办公室关于印发〈贵州省2014年农村义务教育阶段学校教师特设岗位计划实施方案〉的通知》（黔教师发〔2014〕113号）、《州人社局 州教育局关于办理“特岗教师”聘用手续有关问题的通知》（黔南人社通〔2012〕75号）文件精神和县人民政府《惠水县2014年特岗计划承诺书》的相关承诺，经审核，目前有赵成妹等251名“特岗教师”符合服务期满接转到当地任教的条件，经惠水县人民政府常务会议研究，同意将赵成妹等251名“特岗教师”接转为我县正式教师。现进行公示，公示期自发布之日起七个工作日。</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　如对接转人员有异议，请在公示期内向惠水县人力资源和社会保障局人事科反映。</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　联系电话： 0854&#8212;6221862（惠水县人力资源和社会保障局人事科）</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　监督电话： 0854&#8212;6221197 （惠水县纪委监察局）</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　附件：惠水县2014年特岗教师服务期满接转为正式教师花名册.xlsx</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">&#160;</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; TEXT-ALIGN: right; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　惠水县人力资源和社会保障局</p>
<p style="WHITE-SPACE: normal; WORD-SPACING: 0px; TEXT-TRANSFORM: none; COLOR: rgb(0,0,0); PADDING-BOTTOM: 0px; TEXT-ALIGN: right; PADDING-TOP: 0px; FONT: 16px/28px 宋体, sans-serif; PADDING-LEFT: 0px; WIDOWS: 1; MARGIN: 10px 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; TEXT-INDENT: 0px; -webkit-text-stroke-width: 0px">　　2017年11月8日</p>
';
        $content = strtolower($content);
        $pattern = "/<p[^>]*>([^\<|\>]*)<\/p>/is";
        preg_match_all($pattern, $content, $Html);
        // dump($Html[0]);
        $dd = '';
        foreach ($Html[0] as $value) {
            preg_match($pattern, $value, $p1);
            if (strpos($value, 'text-align: right')) {
                $dd .= '<p style="text-align:right;">' . $p1[1] . '</p>';
            } else {
                $dd .= '<p>' . $p1[1] . '</p>';
            }
        }
        dump($dd);
    }
}
