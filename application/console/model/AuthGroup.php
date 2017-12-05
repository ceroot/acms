<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 http://beneng.com All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 * @filename  AuthGroup.php[角色表模型]
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2016-05-08 16:11:20
 * @site      http://www.benweng.com
 */
namespace app\console\model;

use app\common\model\Extend;
use data\Data;
use think\facade\Cache;

class AuthGroup extends Extend
{
    public function getRules($list)
    {
        $rulesTree = [];
        $rules     = Cache::get('authrule');
        foreach ($list as $value) {
            $rulesid = $value['rules'];
            if ($rulesid != '') {
                $rulesidarr = explode(',', $rulesid);
                if (!empty($rulesidarr)) {
                    $rerules = [];
                    foreach ($rulesidarr as $v) {
                        foreach ($rules as $m) {
                            if ($v == $m['id']) {
                                $rerules[] = $m;
                                break;
                            }
                        }
                    }
                    $value['tree'] = Data::tree($rerules, 'title', 'id', 'pid');
                }
            }
            $rulesTree[] = $value;
        }
        return $rulesTree;
    }
}
