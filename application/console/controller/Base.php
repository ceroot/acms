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
        $result = model('action')->find();
        dump($result);die;
        // session('dd', null);
        dump(session('dd'));
        dump(session('paramss'));
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
     * [ menusView 有菜单的 view ]
     * @author   SpringYang <ceroot@163.com>
     * @DateTime 2017-10-27T15:35:41+0800
     * @param    string                   $template [模板名称]
     * @param    array                    $value    [模板显示数据]
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
     * [ lists 通用列表 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:55:34+0800
     * @return   [type]                   [description]
     */
    public function lists()
    {
        if ($this->app->request->isAjax()) {
            $redata = $this->_lists(); // 返回的数据
            $count  = $redata['count']; // 总条数
            $data   = $redata['data']; // 当年
            return $this->success('成功', '', $data, $count);
        } else {
            cookie('__forward__', $_SERVER['REQUEST_URI']);
            return $this->menusView();
        }
    }

    public function liststest()
    {
        $newList = $this->_lists();
        dump($newList);
    }

    /**
     * [ details 通用查看详情方法 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-30T17:33:00+0800
     * @return   [type]                   [description]
     */
    public function details()
    {
        if (!$this->id) {
            return $this->error('参数错误');
        }
        if ($this->isWithTrashed()) {
            $one = $this->model::withTrashed()->find($this->id);
        } else {
            $one = $this->model::get($this->id);
        }
        $this->assign('one', $one);
        // dump($one);die;

        if (request()->isAjax()) {

        }
        return $this->menusView();
    }

    public function detailstest()
    {
        if (!$this->id) {
            return $this->error('参数错误');
        }
        if ($this->isWithTrashed()) {
            $one = $this->model::withTrashed()->find($this->id);
        } else {
            $one = $this->model::get($this->id);
        }
        dump($one);die;
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
     * @return   [type]                       [description]
     */
    public function edit()
    {
        $one = $this->_edit();
        $this->assign('one', $one);
        // dump($one);die;

        return $this->menusView('add');
    }

    public function edittest()
    {
        $user = $this->model->get(61);
        dump($user);
    }

    /**
     * [ renew 通用更新数据操作方法 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:43:40+0800
     * @return   [type]                   [description]
     */
    public function renew()
    {
        return $this->_renew();
    }

    /**
     * [ updatestatus 通用更新 status 字段状态 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-30T16:45:39+0800
     * @return   [type]                   [description]
     */
    public function updatestatus()
    {
        return $this->_updatestatus();
    }

    public function updatestatustest()
    {
        $data = $this->model::get(31);
        dump($data);die;
        $value        = $data->getData('status'); // 取得 status 原始数据
        $data->status = $value ? 0 : 1; // status 数据

        $status = $data->save();
        dump($status);
    }

    /**
     * [ del 通用删除 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T09:52:43+0800
     * @return   [type]                   [description]
     */
    public function del()
    {
        return $this->_del();
    }

    /**
     * [ seting 通用设置 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-03T10:18:50+0800
     * @return   [type]                   [description]
     */
    public function seting()
    {
        if ($this->app->request->isAjax()) {

        } else {
            return $this->menusView();
        }
    }

}
