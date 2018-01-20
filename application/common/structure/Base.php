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
 * @filename  Base.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-20 17:18:59
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\structure;

class Base
{
    //定义错误信息
    protected $error;

    /**
     * [ getError 返回模型的错误信息 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:53:55+0800
     * @return   string|array                   [description]
     */
    public function getError()
    {
        return $this->error;
    }
}
