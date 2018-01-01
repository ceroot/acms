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
 * @filename  BingWallpaper.php
 * @authors   SpringYang
 * @email     ceroo@163.com
 * @QQ        525566309
 * @date      2017-12-14 20:13:23
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\validate;

use think\Validate;

class BingWallpaper extends Validate
{
    protected $rule = [
        'title' => 'require|unique:BingWallpaper',
    ];

    protected $message = [
        'title.require' => '标题必须',
        'title.unique'  => '标题已经存在',
    ];
}
