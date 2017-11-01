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

    }

    function list() {
        cookie('__forward__', $_SERVER['REQUEST_URI']); // 记录当前列表页的cookie
        return $this->fetch();
    }

    public function del()
    {
        return false;
        $status = $this->model->del($this->id);

        if ($status) {

            $this->model->updateCache(); // 更新缓存
            return $this->success('成功');
        } else {
            return $this->error($this->model->getError());
        }
    }

    /**
     * @name   更新菜单显示
     * @author SpringYang <ceroot@163.com>
     */
    public function updateshow()
    {
        return $this->updatefield('isnavshow');
    }

    /**
     * @name   更新权限验证
     * @author SpringYang <ceroot@163.com>
     */
    public function updateauth()
    {
        return $this->updatefield('auth');
    }

    /**
     * @name   更新字段
     * @param  string   $string     [说明]
     * @return boolean              [返回布尔值]
     * @author SpringYang <ceroot@163.com>
     */
    protected function updatefield($field)
    {

        $status = db(request()->controller())->getFieldById($this->id, $field);
        //return $status;
        $data[$field] = ($status == 1) ? 0 : 1;

        $status = $this->model->save($data, [$this->pk => $this->id]);

        if ($status) {
            $this->model->updateCache(); // 更新缓存

            //action_log($this->id); // 记录日志
            return $this->success('成功');
        } else {
            return $this->error('失败');
        }
    }

    /**
     * @name   规则排序
     * @author SpringYang <ceroot@163.com>
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
