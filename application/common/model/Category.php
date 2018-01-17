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
 * @filename  Category.php
 * @authors   SpringYang
 * @email     ceroo@163.com
 * @QQ        525566309
 * @date      2017-11-23 21:38:32
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use app\common\model\Extend;
use think\Db;
use think\facade\Request;

class Category extends Extend
{
    /**
     * [ getMenu 取得显示的菜单 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T14:48:04+0800
     * @return   [type]                   [description]
     */
    public function getMenu()
    {
        $where = [
            ['status', '=', 1],
            ['menu', '=', 0],
        ];
        $field = ['id,pid,sort,name,title,url'];
        $data  = $this->where($where)->field($field)->select();

        $menuData = [];
        foreach ($data as $value) {
            $value['url'] || $value['url'] = url('index/Document/lists', ['id' => $value['id']]);

            $value['active'] = 0;

            if (strtolower(Request::controller()) == 'document') {
                if (strtolower(Request::action()) == 'lists') {
                    Request::param('id') == $value['id'] && $value['active'] = 1;
                } else {
                    $id  = Request::param('id');
                    $cid = Db::name('Document')->getFieldById($id, 'cid');

                    $cid == $value['id'] && $value['active'] = 1;
                }
            }

            if (strtolower(Request::controller()) == 'bing') {
                41 == $value['id'] && $value['active'] = 1;
            }

            $menuData[] = $value;
        }

        return $menuData;
    }
}
