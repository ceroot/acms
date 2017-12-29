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
                $actioninfo = '用户' . $username . '登录失败，失败原因：' . User::getError();
                Hook::listen('action_log', ['action' => 'login', 'record_id' => 0, 'model' => 'manager', 'actioninfo' => $actioninfo]); // 行为日志记录
                return $this->error(User::getError(), '', array('error_num' => $error_num, 'verifyhtml' => $this->verifyhtml()));
            }

            $uid = $user['id'];

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
    public function test()
    {
        set_time_limit(0);
        // $url = 'http://ip.taobao.com/service/getIpInfo.php?ip=1.204.54.195';
        // $ch  = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        // curl_setopt($ch, CURLOPT_NOBODY, true); // remove body
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $head     = curl_exec($ch);
        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
        //
        //         debug('begin');
        // // ...其他代码段
        // debug('end');
        // // ...也许这里还有其他代码
        // // 进行统计区间
        // echo debug('begin','end').'s';
        // echo debug('begin','end',6).'s';
        // echo debug('begin','end','m').'kb';

        debug('begin');
        $startTime = explode(' ', microtime());
        $startTime = $startTime[0] + $startTime[1];
        for ($i = 1; $i <= 10000; $i++) {
            echo $i;
        }
        $endTime   = explode(' ', microtime());
        $endTime   = $endTime[0] + $endTime[1];
        $totalTime = $endTime - $startTime;
        debug('end');
        echo '<br><br><br>';
        echo 'time:' . number_format($totalTime, 10, '.', "") . " seconds</br>";
        echo '<br><br><br>';
        echo 'time:' . debug('begin', 'end') . 's';
        echo '<br><br><br>';
        echo 'time:' . debug('begin', 'end', 10) . 's';
        echo '<br><br><br>';
        echo debug('begin', 'end', 'm') . 'kb';

        die;
        $url    = 'http://ip.taobao.com/service/getIpInfo.php?ip=1.204.54.195';
        $result = url_get_contents($url);
        $result = json_decode($result, true);
        if ($result['code'] !== 0 || !is_array($result['data'])) {
            return false;
        }

        $data = $result['data'];

        dump($data);
        dump($data['region'] . $data['city'] . '|' . $data['isp']);
        // dump(is_dir('../data/temp/'));
        // dump(file_exists('../data/temp/'));
        // make_dir('./data/temp/dd');
        // die;

    }

    public function get_linux_runningTime()
    {
        if (false === ($str = @file("/proc/uptime"))) {
            return false;
        }

        $str   = explode(" ", implode("", $str));
        $str   = trim($str[0]);
        $min   = $str / 60;
        $hours = $min / 60;
        $days  = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min   = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) {
            $res['uptime'] = $days . "天";
        }

        if ($hours !== 0) {
            $res['uptime'] .= $hours . "小时";
        }

        $res['uptime'] .= $min . "分钟";
        return $res;
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
        $data = QueryList::get('http://www.163gz.com/gzzp8/zkxx/20171130/182443.shtml')->rules([
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
        $data = QueryList::get('http://www.163gz.com/gzzp8/zkxx/20171130/182443.shtml')->rules([
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
