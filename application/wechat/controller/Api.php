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

    protected $getReceive; // 获取当前推送的所有数据

    public function initialize()
    {
        parent::initialize();
        $config = Db::name('wechatConfig')->find(1);
        // $data   = cache('wechatdata');
        // dump($data);die;
        $this->wechat = new \WeChat\Receive($config); // 微信菜单实例化

        $this->getReceive = $this->wechat->getReceive(); // 获取当前推送的所有数据

        // $data = $this->wechat->getReceive();
        cache('wechatdata', $this->getReceive);
    }

    // 实例接口，同时实现接口配置验证与解密处理
    // $api = new \WeChat\Receive($config);

    // 获取当前推送接口类型 ( text,image,loction,event... )
    // $msgType = $api->getMsgType();

    // 获取当前推送来源用户的openid
    // $openid = $api->getOpenid();

    // 获取当前推送的所有数据
    // $data = $api->getReceive();

    // 回复文本消息
    // $api->text($content)->reply();

    // 回复图文消息（高级图文或普通图文，数组）
    // $api->news($news)->reply();

    // 回复图片消息（需先上传到微信服务器生成 media_id）
    // $api->image($media_id)->reply();

    // 回复语音消息（需先上传到微信服务器生成 media_id）
    // $api->voice($media_id)->reply();

    // 回复视频消息（需先上传到微信服务器生成 media_id）
    // $api->video($media_id,$title,$desc)->reply();

    // 回复音乐消息
    // $api->music($title,$desc,$musicUrl,$hgMusicUrl,$thumbe)->reply();

    // 将消息转发给多客服务
    // $api->transferCustomerService($account)->reply();
    public function index()
    {
        try {

            // 获取当前推送接口类型 ( text,image,loction,event... )
            $msgType = $this->wechat->getMsgType();

            // 获取当前推送来源用户的openid
            $openid = $this->wechat->getOpenid();

            // return $this->wechat->text('test')->reply();

            switch ($msgType) {
                case 'text':
                    $data = $this->getReceive;
                    return $this->_keys("WechatKeys#keys#" . $data['Content']);
                    break;
                case 'event':
                    // return $this->wechat->text($msgType)->reply();
                    return $this->_event();
                    break;
                case 'image':
                    return $this->_image();
                    break;
                case 'location':
                    return $this->_location();
                    break;
                case 'voice':
                    return $this->_voice();
                    break;
                case 'video':
                    return $this->_video();
                    break;
                case 'file':
                    return $this->_file();
                    # code...
                    break;
                case 'link':
                    return $this->_link();
                    break;
                default:
                    return 'success';
            }

            // $this->wechat->text($openid)->reply();

        } catch (Exception $e) {
            // 处理异常
            echo $e->getMessage();
        }

    }

    public function getdata()
    {
        $data = cache('wechatdata');
        dump($data);
    }

    /**
     * 微信消息接口
     * @return string
     */

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
        // return $this->wechat->text($keys)->reply();
        list($table, $field, $value) = explode('#', $keys . '##');
        $info                        = Db::name($table)->where($field, $value)->find();

        if (is_array($info) && isset($info['type'])) {
            if (array_key_exists('status', $info) && empty($info['status'])) {
                return 'success';
            }
            // cache('wechatdata', $info);
            // return $this->wechat->text($info['type'])->reply();
            switch ($info['type']) {
                case 'customservice': // 多客服
                # code...
                // break;
                case 'keys': // 关键字
                    if (empty($info['content']) && empty($info['name'])) {
                        return $this->_keys('WechatKeys#keys#default');
                    }
                    return $this->_keys('WechatKeys#keys#' . (empty($info['content']) ? $info['name'] : $info['content']));
                // break;
                case 'text':
                    if (empty($info['content'])) {
                        return $this->_keys('WechatKeys#keys#default');
                    } else {
                        return $this->wechat->text($info['content'])->reply();
                    }
                // break;
                case 'customservice2':
                # code...
                // break;
                case 'customservice4':
                # code...
                // break;
                case 'customservice5':
                # code...
                // break;
                case 'customservice6':
                    # code...
                    break;
                default:
                    return $this->_keys('WechatKeys#keys#default');
                    // break;
            }
        } else {
            return $this->_keys('WechatKeys#keys#default');
        }

        //$dd = $info['content'];
        // return $this->wechat->text($dd)->reply();

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
        // array(6) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517934570"
        //   ["MsgType"] => string(5) "event"
        //   ["Event"] => string(5) "CLICK"
        //   ["EventKey"] => string(18) "wechat_menu#id#664"
        // }

        // return $this->wechat->text(11)->reply();
        // return 22;
        // $event = $this->wechat->getRevEvent();
        // $data  = $this->wechat->getReceive();
        $data  = $this->getReceive;
        $event = $data['Event'];
        // return $this->wechat->text($event)->reply();
        // $event = $data['MsgType'];
        switch (strtolower($event)) {
            case 'subscribe': // 粉丝关注事件
                // $this->_updateFansInfo(true);
                // $this->_spread($event['key']);
                return $this->_keys('WechatKeys#keys#subscribe');
            // return $this->_keys('wechat_keys#keys#subscribe', true);
            case 'unsubscribe': // 粉丝取消关注
                $this->_updateFansInfo(false);
                return 'success';
            case 'click': // 点击菜单事件
                // return $this->_keys($event['key']);
                return $this->_keys($data['EventKey']);
            // return $this->_keys("WechatKeys#keys#" . $data['EventKey']);
            // return $this->_keys("WechatKeys#keys#" . $event['key']);
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
        // array(9) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517934476"
        //   ["MsgType"] => string(8) "location"
        //   ["Location_X"] => string(9) "26.549728"
        //   ["Location_Y"] => string(10) "106.680939"
        //   ["Scale"] => string(2) "16"
        //   ["Label"] => string(32) "水岸广场(贵阳市南明区)"
        //   ["MsgId"] => string(19) "6519478932313619161"
        // }
        $data   = $this->getReceive;
        $redata = $data['Label'];
        return $this->wechat->text($redata)->reply();
        return 'success';
    }

    /**
     * 图片事件处理
     */
    private function _image()
    {
        // array(7) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517934207"
        //   ["MsgType"] => string(5) "image"
        //   ["PicUrl"] => string(125) "http://mmbiz.qpic.cn/mmbiz_jpg/jmic0K2iblib5XHOnDYAGAal1CIfaBCNKvpFjoWFoZbrQA5wHGMaw2td2icqp87YYtdWDNjviaVRT7TNricpGgdBEl7w/0"
        //   ["MsgId"] => string(19) "6519477776967416520"
        //   ["MediaId"] => string(64) "A7gqeFIBHXulnw9wGYYxndpbprAEl4gcD3BrPIwoU5-nQK6jnQAP98cGcz3urfqy"
        // }
        $data   = $this->getReceive;
        $redata = $data['MediaId'];
        return $this->wechat->image($redata)->reply();
        return 'success';
    }

    // 语音处理
    private function _voice()
    {
        // array(8) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517934523"
        //   ["MsgType"] => string(5) "voice"
        //   ["MediaId"] => string(64) "VdsAqZUAhjmk4o7l2cZI0ZxndESofJyMVmgRx9qs9UViXPucEyB-Bx2quvaI9_vb"
        //   ["Format"] => string(3) "amr"
        //   ["MsgId"] => string(19) "6519479134177082077"
        //   ["Recognition"] => array(0) {
        //   }
        // }
        $data     = $this->getReceive;
        $media_id = $data['MediaId'];

        return $this->wechat->voice($media_id)->reply();
    }

    // 语音处理
    private function _file()
    {
        //  array(10) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517933995"
        //   ["MsgType"] => string(4) "file"
        //   ["Title"] => string(22) "新建文本文档.txt"
        //   ["Description"] => string(5) "138 B"
        //   ["FileKey"] => string(16) "AgAAAAAAAABQxwJs"
        //   ["FileMd5"] => string(32) "171e2d10af9049b2da07dfbe7de581e9"
        //   ["FileTotalLen"] => string(3) "138"
        //   ["MsgId"] => string(19) "6519476866434349745"
        // }
        $data     = $this->getReceive;
        $media_id = $data['Title'];

        return $this->wechat->text($media_id)->reply();
    }

    // 处理视频
    private function _video()
    {
        // array(7) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517933458"
        //   ["MsgType"] => string(5) "video"
        //   ["MediaId"] => string(64) "20nPGZOXfRVQWLzOrwFryQ2m4fkAiXx0KCvi0-dqVPW-bOaiQjPHBnilBXBklqgK"
        //   ["ThumbMediaId"] => string(64) "LDrM3a2gRtkV10bHAubjWDgo_qtYjkOLdimAWw8_gUYXbXWoiLAXOZWVI4tA4y1B"
        //   ["MsgId"] => string(19) "6519474560036911747"
        // }

        $data     = $this->getReceive;
        $media_id = $data['MediaId'];

        return $this->wechat->video($media_id, '这是标题', '这是描述')->reply();
    }

    // 处理 link
    private function _link()
    {
        // array(8) {
        //   ["ToUserName"] => string(15) "gh_4eb692efe6af"
        //   ["FromUserName"] => string(28) "odL5Rwjo3wFc17EFiKVACH0DJCFY"
        //   ["CreateTime"] => string(10) "1517939941"
        //   ["MsgType"] => string(4) "link"
        //   ["Title"] => string(66) "春节还打扫什么房间？用它擦一擦，邻居全来夸！"
        //   ["Description"] => string(21) "一起来试试吧！"
        //   ["Url"] => string(240) "http://mp.weixin.qq.com/s?__biz=MzI4Nzk0ODA4NQ==&mid=2247484203&idx=1&sn=919ef95fe6012a7d60cb212449d4ca18&chksm=ebc4af71dcb3266756cdc945ec9aa3800c6bf7c9e48e969a928eb420677102d7d86db1133905&mpshare=1&scene=1&srcid=0206ns4K3ir0UXJgxcMIzMJK#rd"
        //   ["MsgId"] => string(19) "6519502404309892277"
        // }

        $data   = $this->getReceive;
        $redata = $data['Title'] | $data['Url'];

        return $this->wechat->text($redata)->reply();
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
