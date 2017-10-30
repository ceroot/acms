<?php
namespace app\console\controller;

use app\common\controller\Extend;
use app\console\traits\Admin;

class Base extends Extend
{
    use Admin;

    protected $model; // 模型
    protected $pk; // 主键键名
    protected $id; // 主键
    /**
     * @name   initialize          [初始化]
     * @author SpringYang <ceroot@163.com>
     * @dateTime
     */
    public function initialize()
    {
        parent::initialize();

        $this->app->cache->has('instantiation_controller') || $this->error('出错');

        $instantiation_controller = cache('instantiation_controller');

        // 判断是否需要实例化的控制器
        if (in_array(strtolower(toUnderline($this->app->request->controller())), $instantiation_controller)) {
            $this->model = $this->app->model($this->app->request->controller()); // 实例化控制器
            $this->pk    = $this->model->getPk(); // 取得主键字段名
            $this->id    = deauthcode($this->app->request->param($this->pk)); // id解密
        }
    }

    public function test()
    {
        $user         = $this->model->get(61);
        $user->status = 0;
        $status       = $user->save();
        dump($status);

    }

    /**
     * [ menusView 有菜单的 view ]
     * @author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-27T15:35:41+0800
     * @param    string                   $template [description]
     * @param    array                    $value    [description]
     * @return   [type]                             [description]
     */
    protected function menusView($template = '', $value = [])
    {
        $menus = $this->getMenus();
        $this->assign('menus', $menus); // 一级菜单输出
        $this->assign('second', $menus['second']); // 二级菜单输出
        $this->assign('title', $menus['showtitle']); // 标题输出
        $this->assign('bread', $menus['bread']); // 面包输出
        return $this->fetch($template, $value);
    }

    /**
     * [ getMenus 取得菜单列表 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:36:27+0800
     * @return   [type]                   [description]
     */
    protected function getMenus()
    {
        return $this->app->model('AuthRule', 'logic')->consoleMenu();
    }

    /**
     * [ index 通用首页 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:37:47+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        $this->assign('commonindex', 'commonindex');
        return $this->menusView('common/index');
    }

    /**
     * [ lists 通用列表 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-27T15:55:34+0800
     * @return   [type]                   [description]
     */
    public function lists()
    {
        if ($this->app->request->isAjax()) {
            $redata = $this->listsData(); // 返回的数据
            $count  = $redata['count']; // 总条数
            $data   = $redata['data']; // 当年
            return $this->success('成功', '', $data, $count);
        } else {
            //$newList = $this->listsData();
            //dump($newList); //die;
            // return json($newList);
            // return $this->success('成功', '', $newList, 100);
            cookie('__forward__', $_SERVER['REQUEST_URI']);
            return $this->menusView();
        }
    }

    /**
     * [ details 通用查看详情方法 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-10-30T17:33:00+0800
     * @return   [type]                   [description]
     */
    public function details()
    {
        if (!$this->id) {
            return $this->error('参数错误');
        }

        $one = $this->model::get($this->id);
        $this->assign('one', $one);

        if (request()->isAjax()) {

        }
        return $this->menusView();
    }

    /**
     * [ add 通用添加 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:38:46+0800
     */
    public function add()
    {
        $this->assign('one', null);
        return $this->menusView();
    }

    /**
     * [ edit 通用编辑 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:38:13+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id = null)
    {
        if (!$this->id) {
            return $this->error('参数错误');
        } else {
            switch (strtolower($this->app->request->controller())) {
                case 'manager': // 管理员编辑数据处理
                    # code...
                    $relationName    = 'UcenterMember'; // 关联方法名称
                    $one             = $this->model::get($this->id, $relationName); // 关联预载入查询
                    $one             = $one->getData(); // 取得原始数据
                    $gdata           = model('AuthGroupAccess')->where('uid', $this->id)->find(); // 查找管理员所属角色
                    $one['group_id'] = $gdata['group_id'];
                    unset($one[toUnderline($relationName)]); // 去掉关联数据
                    break;
                default:
                    $one = $this->model::get($this->id); // 取得数据
                    $one = $one->getData();
                    break;
            }

            $one['editid'] = authcode($one['id']); // 加密编辑 editid
            // dump($one);die;
            $this->assign('one', $one);

            return $this->menusView('add');

        }
    }

    /**
     * [ renew 通用更新数据操作方法 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:43:40+0800
     * @return   [type]                   [description]
     */
    public function renew()
    {
        if ($this->app->request->isPost()) {
            $data = $this->app->request->param();

            return $data;
            //
            //$has_id = array_key_exists($this->pk, $data); // 判断是否存在 ID 键

            // 判断是新增还是更新，如果有键值就是更新，如果没有键值就是新增
            // if ($has_id) {
            // if (input('?param.' . $this->pk)) {
            if ($this->app->request->has($this->pk)) {
                $data[$this->pk] = $this->id;
                if (!$this->id) {
                    return $this->error('参数错误');
                }

                // 各种模式下对数据的处理
                switch ($this->app->request->controller()) {
                    case 'AuthGroup':
                        $rulesdata = input('param.rules/a');
                        if ($rulesdata) {
                            $data['rules'] = implode(',', $rulesdata);
                            session('log_text', '修改了权限');
                        } else {
                            session('log_text', '编辑了角色');
                        }
                        break;
                    case 'Model':
                        if (input('param.field_sort/a')) {
                            $data['field_sort'] = json_encode($data['field_sort']);
                        }
                        if (input('param.attribute_list/a')) {
                            $data['attribute_list'] = arr2str($data['attribute_list']);
                        } else {
                            $data['attribute_list'] = '';
                        }
                        break;
                    case '':
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
                // return $data;

                $scene = 'edit'; // 编辑操作场景
                // $scene = 'edit'; // 编辑操作场景

                // 验证状态设置
                $validate = $this->app->controller() . '.' . $scene;

                if ($this->app->request->param('rule')) {
                    if (input('param.rule') == 1) {
                        $validate = false;
                    }
                }
                // return $data;
                // 数据验证并保存
                $status = $this->model->validate($validate)->save($data, [$this->pk => $this->id]);
                // return $status;

            } else {
                // 数据验证并保存
                $status = $this->model->validate(true)->save($data);
                // return $status;

                $scene = 'add'; // 新增操作场景
            }
            // return 132;
            // 数据验证不通过返回提示
            if ($status === false) {
                return $this->error($this->model->getError());
            }
            // return $status;
            //die;
            // 是否成功返回
            if ($status) {

                $pk        = $this->pk; // 取得数据库主键名称
                $record_id = $this->model->$pk; // 数据 id 值

                switch ($this->app->request->controller()) {
                    case 'AuthRule': // 更新规则缓存
                        // return 132;
                        $this->model->updateCache();
                        // 新增时是否添加日志记录标记
                        if (!$has_id) {
                            model('action')->add_for_rule();
                        }
                        break;
                    case 'Manager': // 管理员操作时的操作
                        // return $data;
                        model('AuthGroupAccess')->saveData($record_id);
                        break;
                    case 'Config': // 清空配置数据缓存
                        cache('db_config_data', null);
                        break;
                    case 'Model': // 清除模型缓存数据
                        cache('document_model_list', null);
                        break;
                    case 'Article': // 内容管理时的数据处理

                        break;
                    default:
                        # code...
                        break;
                }

                // return $this->success($has_id ? '修改成功' : '新增成功', cookie('__forward__'));
                return $this->success(input('?param.' . $this->pk) ? '修改成功' : '新增成功', cookie('__forward__'));
            } else {
                return $this->error('操作失败');
                // return $this->model->getError();
            }
        } else {
            return $this->error('数据有误');
        }
    }

    /**
     * [ updatestatus 通用更新 status 字段状态 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-30T16:45:39+0800
     * @return   [type]                   [description]
     */
    public function updatestatus()
    {

        // 参数判断
        if (!$this->id) {
            return $this->error('参数错误');
        }

        $controller = $this->app->request->controller(); // 取得控制器名称

        // 管理员时的特殊处理
        if (strtolower($controller) == 'manager') {
            if ($this->id == 1) {
                return $this->error('超级管理员不能禁用');
            }
        }

        $data         = $this->model->get($this->id);
        $value        = $data->getData('status'); // 取得 status 原始数据
        $data->status = $value ? 0 : 1; // status 数据

        $status = $data->save();

        // 各种模式下的处理
        if ($status) {
            if ($controller == 'AuthRule') {
                $this->model->updateCache();
            }

            return $this->success('操作成功');
        } else {
            return $this->error('操作失败');
            // return $this->model->getError();
        }

    }
}
