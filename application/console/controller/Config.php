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
 * @filename  Config.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-27 13:44:07
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\Base;

class Config extends Base
{
    public function initialize()
    {
        parent::initialize();

    }

    public function index()
    {
        $group = $this->app->request->param('group');

        $map = [
            ['status', '=', 1],
        ];

        if ($this->app->request->has('group')) {
            $map = [
                ['group', '=', $group],
            ];
        }

        //$list = db('config')->where($map)->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        $list = db('config')->where($map)->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        if (!$list) {
            return $this->error('没有数据');
        } else {
            $this->assign('one', $list);
        }

        return $this->menusView('group');
    }

    public function groupupdate()
    {
        $data = $this->app->request->param();

        $dt = [];
        foreach ($data as $key => $value) {
            $id            = $this->model->getByName($key);
            $temp['id']    = $id['id'];
            $temp['value'] = $value;
            $dt[]          = $temp;
        }

        // return $dt;

        if ($dt) {
            if ($this->model->saveAll($dt)) {
                $this->app->model('app\common\model\Config')->cache_config(); // 更新数据缓存
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            };
        }
    }

    public function lists()
    {

        $group = $this->app->request->param('group');
        $page  = $this->app->request->param('page');

        $map = [];
        if ($this->app->request->has('group')) {
            $map = [
                ['group', '=', $group],
            ];
        }

        // $list = $this->model->where($map)->paginate(10, false, ['page' => $page, 'list_rows' => 10]);
        $list = $this->model->where($map)->paginate();
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $list);
        cookie('__forward__', $_SERVER['REQUEST_URI']); // 记录当前列表页的cookie
        return $this->menusView();
    }
}
