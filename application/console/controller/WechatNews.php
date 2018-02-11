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
 * @filename  WechatNews.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-05 16:45:19
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\WechatBase;

class WechatNews extends WechatBase
{
    protected $wechat;

    public function initialize()
    {
        parent::initialize();

        $this->wechat = new \WeChat\Media($this->config);
    }

    public function index()
    {

        return $this->menusView();
    }

    public function addFile()
    {
        $filename = './static/images/po.jpg';
        if (file_exists($filename)) {
            $type = 'image';
            try {
                // $result = $this->wechat->uploadImg($filename);
                $result = $this->wechat->addMaterial($filename);
                dump($result);
                if ($result) {
                    dump($result);
                } else {
                    dump($this->wechat->getError());
                }
            } catch (Exception $e) {
                dump($e->getMessage());
            }
        } else {
            dump('文件不存在');
        }

    }

    public function wtest($name = 'ddd')
    {
        $newsData = [
            [
                'Title'       => '图文消息标题',
                'Description' => '图文消息描述',
                'PicUrl'      => 'http://mmbiz.qpic.cn/mmbiz_jpg/dmL30YFS5KpEBtIT8TR5KTHXM6t8EiaQmEqgA0uibmFZyBmGENjVlTeugsaOT6GAxFFdcBuLVBia9lHOytHqgOyVg/0?wx_fmt=jpeg',
                'Url'         => 'http://mmbiz.qpic.cn/mmbiz_jpg/dmL30YFS5KpEBtIT8TR5KTHXM6t8EiaQmEqgA0uibmFZyBmGENjVlTeugsaOT6GAxFFdcBuLVBia9lHOytHqgOyVg/0?wx_fmt=jpeg',
            ],
        ];

        $xml = self::arr2xml($newsData);

        dump($xml);

    }

    /**
     * 数组转XML内容
     * @param array $data
     * @return string
     */
    public static function arr2xml($data)
    {
        return "<xml>" . self::_arr2xml($data) . "</xml>";
    }

    /**
     * XML内容生成
     * @param array $data 数据
     * @param string $content
     * @return string
     */
    private static function _arr2xml($data, $content = '')
    {
        foreach ($data as $key => $val) {
            $content .= "<{$key}>";
            if (is_array($val) || is_object($val)) {
                $content .= self::_arr2xml($val);
            } elseif (is_string($val)) {
                $content .= '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $val) . ']]>';
            } else {
                $content .= $val;
            }
            $content .= "</{$key}>";
        }
        return $content;
    }

    public function getlist()
    {
        try {

            // 实例接口
            $wechat = new \WeChat\Media($this->config);

            // 执行操作
            // $result = $wechat->batchGetMaterial($type, $offset, $count);
            $result = $wechat->batchGetMaterial('image');
            dump($result);
        } catch (Exception $e) {
            // 异常处理
            echo $e->getMessage();
        }
    }

    public function add()
    {
        $data = [
            'articles' => [
                'title'              => '这是标题',
                'thumb_media_id'     => '8yn-PFMYV7jK3QH-YtoNIOSak_pcBgRJFogOimYXxjM',
                'author'             => '作者',
                'digest'             => '描述',
                'show_cover_pic'     => '1', // (0/1)
                '“content”'          => '这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容这是内容',
                'content_source_url' => 'content_source_url',
            ],
        ];

        // dump($data);

        $result = $this->wechat->addNews($data);

        dump($result);
    }

    public function getdata()
    {
        //$this->wechat = new \WeChat\Receive($this->config); // 微信菜单实例化
        //$openid       = $this->wechat->getOpenid();
        //$FromUserName = $this->wechat->getToOpenid();

        $newsData = [
            [
                'Title'       => '图文消息标题',
                'Description' => '图文消息描述',
                'PicUrl'      => 'http://mmbiz.qpic.cn/mmbiz_jpg/dmL30YFS5KpEBtIT8TR5KTHXM6t8EiaQmEqgA0uibmFZyBmGENjVlTeugsaOT6GAxFFdcBuLVBia9lHOytHqgOyVg/0?wx_fmt=jpeg',
                'Url'         => 'http://mmbiz.qpic.cn/mmbiz_jpg/dmL30YFS5KpEBtIT8TR5KTHXM6t8EiaQmEqgA0uibmFZyBmGENjVlTeugsaOT6GAxFFdcBuLVBia9lHOytHqgOyVg/0?wx_fmt=jpeg',
            ],
        ];

        $newsData = [
            'CreateTime'   => time(),
            'MsgType'      => 'news',
            'Articles'     => $newsData,
            'ToUserName'   => 123,
            'FromUserName' => 456,
            'ArticleCount' => count($newsData),
        ];
        // dump($newsData);
        $data = cache('wechatdata');
        dump($data);
        $data = cache('xml');
        dump($data);
    }

}
