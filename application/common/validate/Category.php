<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Category.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-29 11:21:53
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'name'  => 'require|unique:Category',
        'title' => 'require|unique:Category',
    ];

    protected $message = [
        'name.require'  => '标识必须',
        'name.unique'   => '标识已经存在',
        'title.require' => '标题必须',
        'title.unique'  => '标题已经存在',
    ];
}
