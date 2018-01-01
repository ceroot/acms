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
 * @filename  Action.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-31 16:44:06
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\validate;

use think\Validate;

class Action extends Validate
{
    protected $rule = [
        'name' => 'require|unique:action',
        'title' => 'require',
    ];

    protected $message = [
        'name.require' => '行为标识必填',
        'name.unique' => '行为标识已存在',
        'title.require' => '行为标题必填',
        // 'title.unique'  => '行为标题已存在',
    ];

}
