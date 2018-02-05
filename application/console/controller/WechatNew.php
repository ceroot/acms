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
 * @filename  WechatNew.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-02-05 16:45:19
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\WechatBase;

class WechatNew extends WechatBase
{

    protected $wechat; // 微信实例化

    public function initialize()
    {
        parent::initialize();
        $this->wechat = new \WeChat\Media($this->config); // 微信菜单实例化
    }

    public function index()
    {

        return $this->menusView();
    }

    public function add()
    {
        $filename = 'http://127.0.0.1:888/data/test.jpg';
        $type     = 'image';
        try {
            $result = $this->wechat->add($filename);
            dump($result);
            if ($result) {
                dump($result);
            } else {
                dump($this->wechat->getError());
            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }

    }

    public function wtest()
    {
        $result = $this->wechat->getMaterialCount();
        dump($result);
        $type   = 'image';
        $offset = 0;
        $count  = 10;
        $result = $this->wechat->batchGetMaterial($type, $offset, $count);
        dump($result);

    }

}
