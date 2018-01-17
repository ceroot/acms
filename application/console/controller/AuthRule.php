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
 * @filename  AuthRule.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-01 17:23:06
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;

class AuthRule extends Base
{

    public function initialize()
    {
        parent::initialize();

        $rule = $this->model->getAll();
        $this->assign('rule', $rule);

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

    }

    /**
     * [ del 删除 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:06:14+0800
     * @return   [type]                   [description]
     */
    public function del()
    {
        $this->id || $this->error('参数错误');

        $status = $this->model->del($this->id);

        if ($status) {
            $this->model->updateCache(); // 更新缓存
            $this->app->hook->listen('action_log', ['record_id' => $this->id]); // 行为日志记录
            return $this->success('成功');
        } else {
            return $this->error($this->model->getError());
        }
    }

    /**
     * [ updateshow 更新菜单显示 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:07:04+0800
     * @return   [type]                   [description]
     */
    public function updateshow()
    {
        return $this->updatefield('isnavshow');
    }

    /**
     * [ updateauth 更新权限验证 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:07:17+0800
     * @return   [type]                   [description]
     */
    public function updateauth()
    {
        return $this->updatefield('auth');
    }

    /**
     * [ updatefield 更新字段 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:07:35+0800
     * @param    string                   $field [字段名称]
     * @param    string                   $value [字段值]
     * @return   boolean                         [返回布尔值]
     */
    protected function updatefield($field, $value = null)
    {
        if (is_null($value)) {
            $value = $this->model->getFieldById($this->id, $field);
            $value = $value ? 0 : 1;
        }

        $status = $this->model->where($this->pk, $this->id)->setField($field, $value);

        if ($status) {
            $this->model->updateCache(); // 更新缓存
            $this->app->hook->listen('action_log', ['record_id' => $this->id]); // 行为日志记录
            return $this->success('成功');
        } else {
            return $this->error('失败');
        }
    }

    /**
     * [ sort 规则排序 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T12:08:32+0800
     * @return   [type]                   [description]
     */
    public function sort()
    {
        if (request()->isPost()) {
            $sortdata = input('param.sort/a');

            foreach ($sortdata as $key => $value) {
                $temp[$this->pk] = $key;
                $temp['sort']    = $value;
                $data[]          = $temp;
            }
            $this->model->saveAll($data);
            $this->model->updateCache(); // 更新缓存
            ///action_log(UID); // 记录日志
            return $this->success('排序成功');
        } else {
            return $this->error('参数错误');
        }
    }
}
