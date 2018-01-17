<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Extend.php 基类控制器
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-30 15:28:24
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\controller;

use think\Container;
use think\Controller;

class Extend extends Controller
{
    protected $app; //容器实例

    /**
     * @name   initialize          [初始化]
     * @author SpringYang <ceroot@163.com>
     * @dateTime
     */
    public function initialize()
    {
        $this->app = Container::getInstance()->make('think\App');

        // 关于服务端url没有#!的处理
        if ($this->app->request->isPut()) {
            $hash = $this->app->request->param('hash');
            if ($hash) {
                $this->app->session->set('hash', $hash);
            } else {
                $this->app->session->set('hash', null);
            }
        } else {
            $this->app->session->set('hash', null);
        }

    }

    /**
     * [ imgResize 输出图片大小 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:43:40+0800
     * @param    string                   $img     [图片路径]
     * @param    integer                  $w       [图片宽度]
     * @param    integer                  $quality [图片清晰度，默认 80]
     * @return   [type]                            [description]
     */
    public function imgResize($img, $w = 500, $quality = 80)
    {
        $image = $img;

        $size   = getimagesize($image); // 得到图像的大小
        $width  = $size[0];
        $height = $size[1];

        $ratio = $width / $height; // 长高比

        $max_width  = $w; //200;
        $max_height = $w / $ratio; //200;

        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

        if (($width <= $max_width) && ($height <= $max_height)) {
            $tn_width  = $width;
            $tn_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $tn_height = ceil($x_ratio * $height);
            $tn_width  = $max_width;
        } else {
            $tn_width  = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }

        $src = imagecreatefromjpeg($image);
        $dst = imagecreatetruecolor($tn_width, $tn_height); //新建一个真彩色图像
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height); //重采样拷贝部分图像并调整大小
        header('Content-Type: image/jpeg');
        imagejpeg($dst, null, $quality); // 图片质量，默认为 80
        imagedestroy($src);
        imagedestroy($dst);
    }

}
