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
 * @filename  Manager.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-01 17:07:27
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\console\controller;

use app\console\controller\Base;
use app\facade\User;

class Manager extends Base
{
    private $ucenterMember;

    public function initialize()
    {
        parent::initialize();

        $this->ucenterMember = $this->app->model('UcenterMember'); // 实例化用户模型

        $groupdata    = db('authGroup')->where('status', 1)->field('id,title,status,describe')->select();
        $authgroup    = db('AuthGroupAccess')->where('uid', input('param.id'))->select();
        $newgroupdata = [];
        foreach ($groupdata as $key => $value) {
            $value['select'] = 0;
            foreach ($authgroup as $k => $v) {
                if ($value['id'] == $v['group_id']) {
                    $value['select'] = 1;
                }
            }
            $newgroupdata[] = $value;
        }

        $this->assign('newgroupdata', $newgroupdata);

    }

    /**
     * [ info 个人信息 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-02T15:03:49+0800
     * @return   [type]                   [description]
     */
    public function info()
    {
        $mid = $this->app->session->get('manager_id');

        if ($this->app->request->isPost()) {

            if (session('manager_id') == 3) {
                return $this->error('测试用户不能修改数据');
            }
            $data = $this->app->request->param();

            if (!$this->id) {
                return $this->error('参数错误');
            }

            $user = $this->model::get($this->id, 'UcenterMember'); // 从数据取得用户数据
            $uid  = $user['uid'];

            if (!$user) {
                return $this->error('用户数据错误');
            }

            // 数据验证
            $data['id'] = $uid;
            $result     = $this->validate($data, 'app\common\validate\UcenterMember.info'); // 数据验证
            if ($result !== true) {
                return $this->error($result);
            }

            // 数据保存
            $status = $this->ucenterMember->save($data, ['id' => $uid]);

            if ($status) {
                $this->app->hook->listen('action_log', ['action' => 'info', 'record_id' => $this->id, 'model' => 'manager']); // 行为日志记录
                return $this->success('个人信息修改成功');
            } else {
                if ($status == 0) {
                    return $this->error('数据没有改变');
                } else {
                    return $this->error('个人信息修改失败');
                }
            }
        } else {
            $one = $this->model->find($mid);
            $one = $this->model::get($one['uid'], 'UcenterMember'); // 从数据取得用户数据

            $one['id'] = authcode($one['id']);

            $this->assign('one', $one);
            return $this->menusView();
        }
    }

    /**
     * [ password 修改密码 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-02T15:03:28+0800
     * @return   [type]                   [description]
     */
    public function password()
    {
        if ($this->app->request->isPost()) {
            if (session('manager_id') == 3) {
                return $this->error('测试用户不能修改数据');
            }
            $data = $this->app->request->param();

            if (!$this->id) {
                return $this->error('参数错误');
            }

            $uid = $this->model->getFieldById($this->id, 'uid'); // 取得用户 id

            if (!$uid) {
                return $this->error('数据有误');
            }

            $result = $this->validate($data, 'app\common\validate\UcenterMember.password'); // 数据验证
            if ($result !== true) {
                return $this->error($result);
            }

            $status = User::modifyPassword($uid, $data['password']); // 数据保存操作

            if ($status) {
                $this->app->hook->listen('action_log', ['record_id' => $this->id]); // 行为日志记录
                return $this->success('修改密码成功');
            } else {
                return $this->error('修改密码失败');
            }

        } else {
            $one['id'] = authcode($this->app->session->get('manager_id'));
            $this->assign('one', $one);
            return $this->menusView();
        }
    }

    public function renew()
    {
        if (request()->isPost()) {
            $data = $this->app->request->param();

            // 判断是更新还是新增
            if ($this->app->request->has($this->pk)) {

                if (!$this->id) {
                    return $this->error('参数错误');
                }

                $user = $this->model::get($this->id, 'UcenterMember'); // 从数据取得用户数据
                $uid  = $user['uid'];

                if (!$user) {
                    return $this->error('用户数据错误');
                }

                $data['username'] || $this->error('请输入用户名');

                $data[$this->pk] = $uid; // 从管理用户表里取得用户表 ID

                // 数据验证
                $result = $this->validate($data, 'app\common\validate\UcenterMember.edit');
                if ($result !== true) {
                    return $this->error($result);
                }

                // 密码处理
                if ($data['password']) {
                    if ($data['password'] != $data['password_confirm']) {
                        return $this->error('两次输入的密码不正确');
                    }

                    $salt = User::getUserInfo($uid, 'salt');
                    if (!$salt) {
                        $salt = getrandom(10, 1);
                    }
                    $data['salt']     = $salt;
                    $data['password'] = encrypt_password($data['password'], $salt); // 密码加密

                } else {
                    unset($data['password']);
                }

                // 先处理管理用户表的数据
                if ($user['status'] != $data['status']) {
                    $this->model->save($data, [$this->pk => $this->id]);
                }

                unset($data['status']); // 去掉状态（因为管理用户表和用户表的状态不一样，所以这里得去掉用户状态）

                // 数据保存
                $status = $this->ucenterMember->save($data, ['id' => $uid]);

                $mid   = $this->id; // 取得管理用户 id
                $scene = 'edit'; // 编辑场景

            } else {
                $result = $this->validate($data, 'app\common\validate\UcenterMember');

                if ($result !== true) {
                    return $this->error($result);
                }

                $salt             = getrandom(10, 1);
                $data['password'] = encrypt_password($data['password'], $salt);
                $data['salt']     = $salt; // 增加 salt

                $status = $this->ucenterMember->save($data); // 数据保存

                // 在管理用户表里新增数据
                if ($status) {
                    $mdata['uid'] = $this->ucenterMember->getLastInsID(); // 取得新增 id;
                    $status       = $this->model->save($mdata); // 保存管理用户数据
                    $mid          = $this->model->getLastInsID(); // 取得管理用户 id
                    $scene        = 'add'; // 编辑场景
                }
            }

            if ($status) {
                model('AuthGroupAccess')->saveData($mid, $data['group_id']); // 角色处理
                $this->app->hook->listen('action_log', ['action' => $scene, 'record_id' => $mid, 'model' => 'manager']); // 行为日志记录
                return $this->success('操作成功');
            } else {
                if ($status == 0) {
                    return $this->error('数据没有改变');
                } else {
                    return $this->error('操作失败');
                }
            }

        }

    }

}
