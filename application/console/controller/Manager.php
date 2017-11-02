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

class Manager extends Base
{

    public function initialize()
    {
        parent::initialize();

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

    public function info()
    {
        $mid = $this->app->session->get('manager_id');

        if (request()->isPost()) {
            $data        = input('param.');
            $mid         = deauthcode($data['id']);
            $data['msg'] = '正确返回';
            // return $data;

            $uid = $this->model->getFieldByUid($mid, 'uid');
            if (!$uid) {
                return $this->error('数据有误');
            }
            $data['id'] = $uid;

            // 实例化用户 api
            $user = new UserApi();

            $resdata = $user->update($data);
            return $resdata;
            if ($resdata == 1) {
                action_log($mid); // 记录操作日志
                return $this->success('个人信息修改成功');
            } else {
                return $resdata;
                return $this->error('个人信息修改失败');
            }

        } else {
            $one       = $this->model->find($mid);
            $user      = new UserApi();
            $one       = $user->getone($mid);
            $one['id'] = authcode($one['id']);
            $this->assign('one', $one);
            return $this->fetch();
        }
    }

    public function renew()
    {
        if (request()->isPost()) {
            $data = $this->app->request->param();
            // return $data;
            $ucenterMember = $this->app->model('UcenterMember'); // 实例化用户模型

            // 判断是更新还是新增
            if ($this->app->request->has($this->pk)) {

                if (!$this->id) {
                    return $this->error('参数错误');
                }

                $user = $this->model::get($this->id, 'UcenterMember'); // 从数据取得用户数据

                if (!$user) {
                    return $this->error('用户数据错误');
                }

                $mid = $user['id']; // 管理用户id

                $data['username'] || $this->error('请输入用户名');

                $nameCount = $ucenterMember->where('username', $data['username'])->select()->count();
                if ($nameCount > 1) {
                    return $this->error('用户名已存在，请换一个');
                }

                $nickCount = $ucenterMember->where('nickname', $data['username'])->select()->count();
                if ($nameCount > 1) {
                    return $this->error('用户名昵称已存在，请换一个');
                }

                $emailCount = $ucenterMember->where('email', $data['username'])->select()->count();
                if ($emailCount > 1) {
                    return $this->error('邮箱已存在，请换一个');
                }

                $mobileCount = $ucenterMember->where('mobile', $data['username'])->select()->count();
                if ($mobileCount > 1) {
                    return $this->error('手机已存在，请换一个');
                }

                // 密码处理
                if ($data['password']) {
                    if ($data['password'] != $data['password_confirm']) {
                        return $this->error('两次输入的密码不正确');
                    }
                    $data['password'] = encrypt_password($data['password'], $user['ucenter_member']['salt']); // 密码加密
                } else {
                    unset($data['password']);
                }

                // 先处理管理用户表的数据
                if ($user['status'] != $data['status']) {
                    $this->model->save($data, [$this->pk => $this->id]);
                }

                $data[$this->pk] = $user['uid']; // 从管理用户表里取得用户表 ID

                unset($data['status']); // 去掉状态（因为管理用户表和用户表的状态不一样，所以这里得去掉用户状态）

                // 数据保存
                $status = $ucenterMember->save($data, ['id' => $user['uid']]);
                $mid    = $ucenterMember->id; // 取得管理用户 id
                $scene  = 'edit'; // 编辑场景

            } else {
                $result = $this->validate($data, 'app\common\validate\UcenterMember');

                if ($result !== true) {
                    return $this->error($result);
                }

                $salt             = getrandom(10, 1);
                $data['password'] = encrypt_password($data['password'], $salt);
                $data['salt']     = $salt; // 增加 salt

                $status = $ucenterMember->save($data); // 数据保存

                // 在管理用户表里新增数据
                if ($status) {
                    $mdata['uid'] = $ucenterMember->getLastInsID(); // 取得新增 id;
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
