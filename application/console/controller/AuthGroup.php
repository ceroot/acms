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
 * @filename  Action.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-02 16:28:07
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;

class AuthGroup extends Base
{
    public function initialize()
    {
        parent::initialize();

    }

    public function lists()
    {
        $pageLimit = $this->app->request->param('limit');
        $pageLimit = isset($pageLimit) ? $pageLimit : 5; // 每页显示数目
        $pk        = $this->model->getPk(); // 取得主键字段名

        $order = [
            $pk => 'asc',
        ];

        $list = $this->model->order($order)->paginate($pageLimit);
        $page = $list->render();
        foreach ($list as $value) {
            $value['editid'] = authcode($value['id']);
            $newlist[]       = $value;
            # code...
        }
        $rulesTree = $this->model->getRules($newlist);

        $this->assign('list', $rulesTree);
        $this->assign('page', $page);

        // 记录当前列表页的cookie
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        return $this->menusView();
    }
    public function rule()
    {
        $rules = model('authRule')->getAll(1);
        $this->assign('rules', $rules);

        $field = db('authGroup')->find(deauthcode(input('param.id')));
        $this->assign('field', $field);
        return $this->menusView();
    }

}
