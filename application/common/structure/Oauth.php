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
 * @filename  Oauth.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-12-07 13:01:48
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\structure;

use app\common\traits\Models;
use think\facade\App;

class Oauth
{

    use Models;

    private $UcenterMember;

    /**
     * [ __construct 初始化 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-10-25T14:13:18+0800
     */
    public function __construct()
    {
        $this->UcenterMember = App::model('UcenterMember'); // 实例化用户模型
    }

}
