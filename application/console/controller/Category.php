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
 * @filename  Action.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-27 16:44:07
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;
use data\Data;

class Category extends Base
{
    public function initialize()
    {
        parent::initialize();
        $category = $this->model->select();
        $category = $category->toArray();

        $newcategory = [];
        foreach ($category as $value) {
            $value['editid'] = authcode($value['id']);

            // 修改时在低级选项里不能显示自己
            if ($this->app->request->has($this->pk) && $this->id == $value['id']) {
                // unset(1);
            } else {
                $newcategory[] = $value;
            }
        }
        // 新增子规则的时候给 pid
        if ($this->app->request->action() == 'add') {
            if ($this->app->request->has('id')) {
                $_pid = deauthcode($this->app->request->param('id'));
                $this->assign('_pid', $_pid);
            } else {
                $this->assign('_pid', null);
            }
        } else {
            $this->assign('_pid', null);
        }

        $category = Data::tree($newcategory, 'title', 'id', 'pid');
        // dump($category);die;
        $this->assign('category', $category);

    }
}
