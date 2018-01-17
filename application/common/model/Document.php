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
 * @filename  Document.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-29 10:34:27
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\model;

use app\common\model\Extend;
use think\model\concern\SoftDelete;

class Document extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}
