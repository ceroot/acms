<?php
namespace app\console\controller;

use app\console\traits\Admin;
use think\Controller;

class Base extends Controller
{
    use Admin;

    protected $app; //容器实例
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

        //$this->app = Container::getInstance()->make('think\App');

        // parent::initialize();
        $instantiation_controller = cache('instantiation_controller');
        // 判断是否需要实例化的控制器
        if (in_array(strtolower(toUnderline($this->app->request->controller())), $instantiation_controller)) {
            $this->model = $this->app->model($this->app->request->controller()); // 实例化控制器
            $this->pk    = $this->model->getPk(); // 取得主键字段名
            $this->id    = deauthcode($this->app->request->param($this->pk)); // id解密
        }
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
     * [ add 通用添加 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:38:46+0800
     */
    public function add()
    {
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
        dump('edit');
        return $this->menusView();
    }

    /**
     * [ renew 通用更新数据操作方法 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:43:40+0800
     * @return   [type]                   [description]
     */
    public function renew()
    {

    }
}
