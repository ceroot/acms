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

    /**
     * [ index 配置首页 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-09T10:24:08+0800
     * @return   [type]                   [description]
     */
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

        $list = db('config')->where($map)->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        $list || $this->error('没有数据');
        $newlist = [];
        foreach ($list as $value) {
            if ($value['type'] == 'radio') {
                $value['extra'] = $this->parse('radio', $value['extra']);
            }
            $newlist[] = $value;
        }
        $this->assign('one', $newlist);
        return $this->menusView('group');
    }

    /**
     * [ parse 根据配置类型解析配置 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-09T10:24:38+0800
     * @param    integer                   $type  [配置类型]
     * @param    string                    $value [配置值]
     * @return   [type]                           [description]
     */
    private static function parse($type, $value)
    {
        switch ($type) {
            case 'radio': //解析数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if (strpos($value, ':')) {
                    $value = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                } else {
                    $value = $array;
                }
                break;
        }
        return $value;
    }

    /**
     * [ groupupdate 修改操作 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-09T10:25:38+0800
     * @return   [type]                   [description]
     */
    public function groupupdate()
    {
        $data = $this->app->request->param();

        $datatemp = [];
        foreach ($data as $key => $value) {
            $id            = $this->model->getByName($key);
            $temp['id']    = $id['id'];
            $temp['value'] = $value;
            $datatemp[]    = $temp;
        }

        if ($datatemp) {
            if ($this->model->saveAll($datatemp)) {
                $this->app->model('app\common\model\Config')->cache_config(); // 更新数据缓存
                $this->app->hook->listen('action_log', ['action' => 'edit', 'record_id' => 0]); // 行为日志记录
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            };
        }
    }

    /**
     * [ lists 列表页 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-09T10:25:55+0800
     * @return   [type]                   [description]
     */
    public function lists()
    {
        $group = $this->app->request->param('group');

        $map = [];
        if ($this->app->request->has('group')) {
            $map = [
                ['group', '=', $group],
            ];
        }

        $list = $this->model->where($map)->paginate();
        $this->assign('list', $list);
        cookie('__forward__', $_SERVER['REQUEST_URI']); // 记录当前列表页的cookie
        return $this->menusView();
    }
}
