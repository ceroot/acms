<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Collection.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-12 11:29:45
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use app\common\model\Extend;

class Collection extends Extend
{
    /**
     * [ getCount 取得文档收藏数 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T12:07:14+0800
     * @param    integer                   $mid   [模型 id]
     * @param    integer                   $did   [文档 id]
     * @return   integer                   $count [返回统计数]
     */
    public function getCount($mid, $did)
    {
        $where = [
            ['mid', '=', $mid],
            ['did', '=', $did],
        ];

        $count = $this->where($where)->count();
        return $count;
    }

    /**
     * [ getUserCount 取得用户的收藏数 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T12:11:38+0800
     * @param    integer                   $uid   [用户 id]
     * @param    integer                   $did   [文档 id]
     * @return   integer                   $count [返回统计数]
     */
    public function getUserCount($uid, $did)
    {
        $where = [
            ['uid', '=', $uid],
            ['did', '=', $did],
        ];

        $count = $this->where($where)->count();
        return $count;
    }
}
