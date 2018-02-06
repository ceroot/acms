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

    public function add()
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
        dump($name);die;
        // $media_id = 'pOoIye4ddDRZxKnvP5Bei15Bs7kUECQUFhNBGc5aZ0ddmjvsP-Fgw_UVOhZk_sB6';
        // $result   = $this->wechat->get($media_id);
        // $result   = '<img src="' . $result . '">';
        // echo $result;die;
        // dump($result);
        // die;
        $result = $this->wechat->getMaterialCount();
        dump($result);
        $type   = 'image';
        $offset = 0;
        $count  = 10;
        $result = $this->wechat->batchGetMaterial($type, $offset, $count);
        dump($result);

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

}
