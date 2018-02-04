<?php
namespace app\index\controller;

use Jenssegers\Agent\Agent;
use think\helper\Str;
use think\helper\Time;

class Index
{
    public function index()
    {
        return view();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function test()
    {
        return view();
    }
    public function test1()
    {
        $dd   = \Db::name('wechatConfig'); //
        $fi   = $dd->getTableFields();
        $ft   = $dd->getFieldsType();
        $data = $dd->find(1);
        // dump($fi);
        // dump($ft);
        // dump($data);
        // die;

        list($start, $end) = Time::today();

        echo $start; // 零点时间戳
        echo '<br/>';
        echo $end; // 23点59分59秒的时间戳

        dump(date('Y-m-d H:i:s', $end));
        dump(Time::daysAgo(7));
        dump(Time::daysToSecond(5));
        dump(Str::random());

        return view();
    }

    public function dj()
    {
        return view();
    }

    public function fullpage()
    {
        return view();
    }

    public function scale()
    {
        return view();
    }

    public function itest()
    {
        // dump(Agent::is('Windows'));

        $agent = new Agent();
        //设置User Agent，比如在cli模式下用到
        //$agent->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2');
        //$agent->setHttpHeaders($headers);
        //Is方法检测（如：操作系统）
        dump($agent->is('Windows'));
        dump($agent->is('Firefox'));
        dump($agent->is('iPhone'));
        dump($agent->is('OS X'));
        //魔法方法（如： 厂商产品定位）
        dump($agent->isAndroidOS());
        dump($agent->isNexus());
        dump($agent->isSafari());
        //识别移动设备
        dump($agent->isMobile()); //手机
        dump($agent->isTablet()); //平板
        dump($agent->isDesktop()); //桌面端
        // 语言
        dump($languages = $agent->languages());
        // ['nl-nl', 'nl', 'en-us', 'en']
        // 是否是机器人
        dump('是否是机器人：');
        dump($agent->isRobot());
        // 获取设备信息 (iPhone, Nexus, AsusTablet, ...)
        dump('device：');
        dump($agent->device());
        // 系统信息  (Ubuntu, Windows, OS X, ...)
        dump($agent->platform());
        // 浏览器信息  (Chrome, IE, Safari, Firefox, ...)
        dump($agent->browser());
        // 获取浏览器版本
        dump($browser = $agent->browser());
        dump($version = $agent->version($browser));
        // 获取系统版本
        dump($platform = $agent->platform());
        dump($version = $agent->version($platform));
    }

    public function livesone()
    {
        return view();
    }
}
