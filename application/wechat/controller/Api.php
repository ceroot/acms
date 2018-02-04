<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Api.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-31 11:25:05
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\wechat\controller;

use service\DataService;
use service\WechatService;
use think\Controller;
use think\Db;
use think\facade\Log;
use think\facade\Request;
use Wechat\WechatReceive;

class Api extends Controller
{
    /**
     * 微信openid
     * @var string
     */
    protected $openid;

    /**
     * 微信消息对象
     * @var WechatReceive
     */
    protected $wechat;

    /**
     * 微信消息接口
     * @return string
     */
    public function index()
    {
        // 实例接口对象
        $this->wechat = &load_wechat('Receive');
        //ob_clean();
        // $keys = $this->wechat->getRevContent();
        // return $this->wechat->text($keys)->reply();

        // 验证接口请求
        if ($this->wechat->valid() === false) {

            $msg = "{$this->wechat->errMsg}[{$this->wechat->errCode}]";
            // Log::error($this->wechat->errMsg);
            // Log::error($this->wechat->errCode);
            Log::error($msg);
            Log::record('[ wechat ]：' . $msg);
            // dump("{$this->wechat->errMsg}");
            // dump("{$this->wechat->errCode}");
            // dump($msg);
            return $msg;
        }

        // 获取消息来源用户OPENID
        $this->openid = $this->wechat->getRev()->getRevFrom();
        // 获取并同步粉丝信息到数据库
        $this->_updateFansInfo(true);
        //return $this->wechat->text($this->wechat->getRev()->getRevType())->reply();
        // 分别执行对应类型的操作
        switch ($this->wechat->getRev()->getRevType()) {
            case WechatReceive::MSGTYPE_TEXT:
                return $this->_keys("WechatKeys#keys#" . $this->wechat->getRevContent());
            // return $this->_keys("WechatKeys#keys#" . $this->wechat->getRevContent());
            case WechatReceive::MSGTYPE_EVENT:
                return $this->_event();
            case WechatReceive::MSGTYPE_IMAGE:
                return $this->_image();
            case WechatReceive::MSGTYPE_LOCATION:
                return $this->_location();
            default:
                return 'success';
        }
    }

    public function test()
    {
        $keys = 'WechatKeys#keys#' . 'default';

        list($table, $field, $value) = explode('#', $keys . '##');

        dump($table);
        dump($field);
        dump($value);

        $info = Db::name($table)->where($field, $value)->find();
        dump($info);

    }

    public function user()
    {
        // 实例微信粉丝接口
        $user = &load_wechat('User');

        // 读取微信粉丝列表
        $result = $user->getUserList();
        $dd     = $user->getTags();
        dump($result);
        dump($dd);

        // 处理创建结果
        if ($result === false) {
            // 接口失败的处理
            echo $user->errMsg;
        } else {
            // 接口成功的处理
        }
    }

    public function menu()
    {
        $menu = &load_wechat('menu');

        // 执行接口操作
        $access_token = $menu->getAccessToken();
        // dump($result);
        // die;
        // $result = $menu->getMenu();die;
        // $data = [
        //     ["type" => "view", "name" => "官网", "url" => "http://www.kan.cn/"],
        //     ["type" => "view", "name" => "测试", "url" => "http://www.baidu.com/"],
        //     ["name" => "我", "sub_button" => [
        //         ["type" => "click", "name" => "支付测试", "key" => "http://pay.kan.cn/wx/wxpay/index"],
        //         ["type" => "view", "name" => "商务合作", "url" => "http://pay.kan.cn/wx/index/login"],
        //     ],
        //     ],
        // ];
        // $data = {"button":[ { "type":"click", "name":"今日歌曲", "key":"V1001_TODAY_MUSIC" }, { "type":"click", "name":"歌手简介", "key":"V1001_TODAY_SINGER" }, { "name":"菜单", "sub_button":[ { "type":"click", "name":"hello word", "key":"V1001_HELLO_WORLD" }, { "type":"click", "name":"赞一下我们", "key":"V1001_GOOD" }] }] };
        $data = ['button' => [
            ['type' => 'click', 'name' => '笑语', 'key' => 123],
            ['type' => 'click', 'name' => '行程', 'key' => 5555],
            ['name' => '菜单', 'sub_button' => [
                ['type' => 'view', 'name' => '个人中心', 'url' => 'https://www.benweng.com/wechat/api/login'],
                ['type' => 'view', 'name' => '视频', 'url' => 'http://v.qq.com/'],
                ['type' => 'click', 'name' => '赞一下我们', 'key' => 66666],
            ]],
        ]];
        // $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        // dump($data);
        // $data = '{
        //      "button":[
        //      {
        //           "type":"click",
        //           "name":"今日歌曲",
        //           "key":"111"
        //       },
        //       {
        //            "type":"click",
        //            "name":"歌手简介",
        //            "key":"5555"
        //       },
        //       {
        //            "name":"菜单",
        //            "sub_button":[
        //            {
        //                "type":"view",
        //                "name":"搜索",
        //                "url":"http://www.soso.com/"
        //             },
        //             {
        //                "type":"view",
        //                "name":"视频",
        //                "url":"http://v.qq.com/"
        //             },
        //             {
        //                "type":"click",
        //                "name":"赞一下我们",
        //                "key":"333"
        //             }]
        //        }]
        //  }';
        // // dump($data);
        // // die;

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $tmpInfo = curl_exec($ch);
        // if (curl_errno($ch)) {
        //     echo curl_error($ch);
        // }

        // curl_close($ch);

        // echo $tmpInfo;
        // die;
        dump($data);die;
        // 创建微信菜单
        $result = $menu->createMenu($data);

        // 处理创建结果
        if ($result === false) {
            // 接口失败的处理
            echo $menu->errMsg;
        } else {
            // 接口成功的处理
            dump('成功');
        }
    }

    public function ddd()
    {
        list($map, $fields) = [['status' => '1'], 'id,index,pindex,name,type,content'];

        $result = (array) Db::name('WechatMenu')->field($fields)->where($map)->order('sort ASC,id ASC')->select();

    }

    public function menuok()
    {
        // dump(1);die;
        $menu = &load_wechat('menu');
        // dump($menu);
        // 执行接口操作
        $access_token = $menu->getAccessToken();
        // dump($access_token);die;

        $data = ['button' => [
            ['type' => 'click', 'name' => '笑语', 'key' => 123],
            ['type' => 'click', 'name' => '行程', 'key' => 5555],
            ['name' => '菜单', 'sub_button' => [
                ['type' => 'view', 'name' => '个人中心', 'url' => 'https://www.benweng.com/wechat/api/login'],
                ['type' => 'view', 'name' => '视频', 'url' => 'http://v.qq.com/'],
                ['type' => 'click', 'name' => '赞一下我们', 'key' => 66666],
            ]],
        ]];
        // $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        // dump($data);
        $data = '{
             "button":[
             {
                  "type":"click",
                  "name":"今日歌曲",
                  "key":"111"
              },
              {
                   "type":"click",
                   "name":"歌手简介",
                   "key":"5555"
              },
              {
                   "name":"菜单",
                   "sub_button":[
                   {
                       "type":"view",
                       "name":"搜索",
                       "url":"http://www.soso.com/"
                    },
                    {
                       "type":"view",
                       "name":"视频",
                       "url":"http://v.qq.com/"
                    },
                    {
                       "type":"click",
                       "name":"赞一下我们",
                       "key":"333"
                    }]
               }]
         }';
        // dump($data);
        // die;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }

        curl_close($ch);

        echo $tmpInfo;
    }

    public function ucenter()
    {
        dump('ucenter');
    }

    /**
     * 关键字处理
     * @param string $keys
     * @param bool $isForce
     * @return string
     */
    private function _keys($keys, $isForce = false)
    {
        // return $this->wechat->text($keys)->reply();
        list($table, $field, $value) = explode('#', $keys . '##');
        if (is_array($info = Db::name($table)->where($field, $value)->find()) && isset($info['type'])) {
            // 数据状态检查
            if (array_key_exists('status', $info) && empty($info['status'])) {
                return 'success';
            }
            switch ($info['type']) {
                case 'customservice': // 多客服
                    $this->wechat->sendCustomMessage(['touser' => $this->openid, 'msgtype' => 'text', 'text' => ['content' => $info['content']]]);
                    return $this->wechat->transfer_customer_service()->reply(false, true);
                case 'keys': // 关键字
                    if (empty($info['content']) && empty($info['name'])) {
                        return 'success';
                    }
                    return $this->_keys('wechat_keys#keys#' . (empty($info['content']) ? $info['name'] : $info['content']));
                case 'text': // 文本消息
                    if (empty($info['content']) && empty($info['name'])) {
                        return 'success';
                    }
                    return $this->wechat->text($info['content'])->reply(false, true);
                case 'news': // 图文消息
                    if (empty($info['news_id'])) {
                        return 'success';
                    }
                    return $this->_news($info['news_id']);
                case 'music': // 音频消息
                    if (empty($info['music_url']) || empty($info['music_title']) || empty($info['music_desc'])) {
                        return 'success';
                    }
                    $media_id = empty($info['music_image']) ? '' : WechatService::uploadForeverMedia($info['music_image'], 'image');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->music($info['music_title'], $info['music_desc'], $info['music_url'], $info['music_url'], $media_id)->reply(false, true);
                case 'voice': // 语音消息
                    if (empty($info['voice_url'])) {
                        return 'success';
                    }
                    $media_id = WechatService::uploadForeverMedia($info['voice_url'], 'voice');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->voice($media_id)->reply(false, true);
                case 'image': // 图文消息
                    if (empty($info['image_url'])) {
                        return 'success';
                    }
                    $media_id = WechatService::uploadForeverMedia($info['image_url'], 'image');
                    if (empty($media_id)) {
                        return 'success';
                    }
                    return $this->wechat->image($media_id)->reply(false, true);
                case 'video': // 视频消息
                    if (empty($info['video_url']) || empty($info['video_desc']) || empty($info['video_title'])) {
                        return 'success';
                    }
                    $data     = ['title' => $info['video_title'], 'introduction' => $info['video_desc']];
                    $media_id = WechatService::uploadForeverMedia($info['video_url'], 'video', true, $data);
                    return $this->wechat->video($media_id, $info['video_title'], $info['video_desc'])->reply(false, true);
            }
        }
        if ($isForce) {
            return 'success';
        }
        return $this->_keys('wechat_keys#keys#default', true);
    }

    /**
     * 回复图文
     * @param int $news_id
     * @return bool|string
     */
    protected function _news($news_id = 0)
    {
        if (is_array($newsinfo = WechatService::getNewsById($news_id)) && !empty($newsinfo['articles'])) {
            $newsdata = [];
            foreach ($newsinfo['articles'] as $vo) {
                $newsdata[] = [
                    'Title'       => $vo['title'],
                    'Description' => $vo['digest'],
                    'PicUrl'      => $vo['local_url'],
                    'Url'         => url("@wechat/review", '', true, true) . "?content={$vo['id']}&type=article",
                ];
            }
            return $this->wechat->news($newsdata)->reply(false, true);
        }
        return 'success';
    }

    /**
     * 事件处理
     */
    protected function _event()
    {
        $event = $this->wechat->getRevEvent();
        switch (strtolower($event['event'])) {
            case 'subscribe': // 粉丝关注事件
                $this->_updateFansInfo(true);
                $this->_spread($event['key']);
                return $this->_keys('wechat_keys#keys#subscribe', true);
            case 'unsubscribe': // 粉丝取消关注
                $this->_updateFansInfo(false);
                return 'success';
            case 'click': // 点击菜单事件
                // return $this->_keys($event['key']);
                return $this->_keys("WechatKeys#keys#" . $event['key']);
            case 'scancode_push':
            case 'scancode_waitmsg': // 扫码推事件
                $scanInfo = $this->wechat->getRev()->getRevScanInfo();
                if (isset($scanInfo['ScanResult'])) {
                    return $this->_keys($scanInfo['ScanResult']);
                }
                return 'success';
            case 'scan':
                if (!empty($event['key'])) {
                    return $this->_spread($event['key']);
                }
                return 'success';
        }
        return 'success';
    }

    /**
     * 推荐好友扫码关注
     * @param string $event
     * @return mixed
     */
    private function _spread($event)
    {
        $key = preg_replace('|^.*?(\d+).*?$|', '$1', "{$event}");
        // 检测推荐是否有效
        $fans = Db::name('WechatFans')->where('id', $key)->find();
        if (!is_array($fans) || !isset($fans['openid']) || $fans['openid'] === $this->openid) {
            return false;
        }
        // 标识推荐关系
        $data = ['spread_openid' => $fans['openid'], 'spread_at' => date('Y-m-d H:i:s')];
        Db::name('WechatFans')->where("openid='{$this->openid}' and (spread_openid is null or spread_openid='')")->setField($data);
        // @todo 推荐成功的奖励
    }

    /**
     * 位置事情回复
     * @return string
     */
    private function _location()
    {
        return $this->wechat->text('success')->reply();
        return 'success';
    }

    /**
     * 图片事件处理
     */
    private function _image()
    {
        return $this->wechat->text('success')->reply();
        return 'success';
    }

    /**
     * 同步粉丝状态
     * @param bool $subscribe 关注状态
     */
    protected function _updateFansInfo($subscribe = true)
    {
        if ($subscribe) {
            $fans = WechatService::getFansInfo($this->openid);
            if (empty($fans) || empty($fans['subscribe'])) {
                $wechat                = &load_wechat('User');
                $userInfo              = $wechat->getUserInfo($this->openid);
                $userInfo['subscribe'] = intval($subscribe);
                WechatService::setFansInfo($userInfo, $wechat->appid);
            }
        } else {
            $data = ['subscribe' => '0', 'appid' => $this->wechat->appid, 'openid' => $this->openid];
            DataService::save('wechat_fans', $data, 'openid');
        }
    }

    public function login()
    {
        // $request  = Request::instance();
        // $callback = $request->url(true);
        // dump($callback);die;

        if (isset($_GET['code'])) {
            $oauth  = &load_wechat('Oauth');
            $result = $oauth->getOauthAccessToken();

            // 处理返回结果
            if ($result === false) {
                // 接口失败的处理
                return false;
            } else {
                // 接口成功的处理
                $access_token = $result['access_token'];
                $openid       = $result['openid'];
                $userinfo     = db('member')->where('openid', $openid)->find();
                if (!$userinfo) {
                    $result = $oauth->getOauthUserinfo($access_token, $openid);
                    if ($result) {
                        cookie('userinfo', $result, 86400);
                        $this->jump();
                    } else {

                        $this->redirect('https://www.benweng.com/wechat/api/userinfo');
                    }
                } else {
                    cookie('userinfo', $userinfo, 86400);
                    $this->jump();
                }
            }
        } else {
            $request = Request::instance();

            // $callback = $request->url(true);
            $callback = 'www.benweng.com';

            $state  = 'STATE';
            $scope  = 'snsapi_base'; //snsapi_userinfo
            $oauth  = &load_wechat('Oauth');
            $result = $oauth->getOauthRedirect($callback, $state, $scope);
            // dump($result);die;
            if ($result === false) {
                // 接口失败的处理
                return false;
            } else {
                // 接口成功的处理
                header("Location:" . $result);die;
            }
        }
    }

    public function userinfo()
    {
        if (isset($_GET['code'])) {
            $oauth  = &load_wechat('Oauth');
            $result = $oauth->getOauthAccessToken();
            // 处理返回结果
            if ($result === false) {
                // 接口失败的处理
                return false;
            } else {
                // 接口成功的处理
                $request = Request::instance();
                $data    = array(
                    'name'       => $userinfo['nickname'],
                    'password'   => md5('123456'),
                    'loginip'    => $request->ip(),
                    'headimgurl' => $userinfo['headimgurl'],
                    'nickname'   => $userinfo['nickname'],
                    'openid'     => $userinfo['openid'],
                    'ctime'      => time(),
                    'lasttime'   => time(),
                );
                $res = db('member')->insert($data);
                cookie('userinfo', $result, 86400);
                $this->jump();
            }
        } else {
            $request  = Request::instance();
            $callback = $request->url(true);
            $state    = 'STATE';
            $scope    = 'snsapi_userinfo'; //snsapi_userinfo
            $oauth    = &load_wechat('Oauth');
            $result   = $oauth->getOauthRedirect($callback, $state, $scope);
            if ($result === false) {
                // 接口失败的处理
                return false;
            } else {
                // 接口成功的处理
                header("Location:" . $result);
                die;
            }
        }
    }

    public function jump()
    {
        $jump = cookie('jumpurl');
        if ($jump) {
            $url = $jump;
        } else {
            // $url = 'index/index';
            $url = 'https://www.benweng.com/wechat/api/ucenter';
        }
        $this->redirect($url);
    }
}
