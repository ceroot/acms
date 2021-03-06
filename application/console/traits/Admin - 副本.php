<?php

namespace app\console\traits;

use think\Container;
use think\Facade;
use traits\controller\Jump;

trait Admin
{
    use Jump;

    //容器实例
    protected $app;
    //视图
    protected $view;
    // 菜单
    protected $menus;

    /**
     * 初始化容器
     */
    public function __construct()
    {

        $this->app = Container::getInstance()->make('think\App');

        //绑定其他类到容器
        $this->bindContainer();
    }

    public function bindContainer()
    {

    }

    /**
     * 设置视图并输出
     * @author staitc7 <static7@qq.com>
     * @param array  $value 赋值
     * @param string $template 模板名称
     * @param bool   $menus 菜单
     * @return mixed
     */
    // protected function setView(?array $value = [], ?string $template = '',$menus=true)
    protected function setView($value = [], $template = '', $menus = true)
    {
        $value    = is_array($value) ? $value : (array) $value;
        $template = is_string($template) ? $template : '';

        //模板初始化
        $this->view = $this->view ?: Facade::make('view')->init(
            $this->app->config->pull('template'), //模板引擎
            $this->app->config->get('view_replace_str') //替换参数
        );

        //开启系统菜单
        //$menus && $this->view->assign('systemMenus', $this->getMenus());

        $this->$menus = $this->getMenus();
        $this->view->assign('menus', $this->$menus);
        $this->view->assign('second', $this->$menus['second']); // 二级菜单输出
        $this->view->assign('title', $this->$menus['showtitle']); // 标题输出
        $this->view->assign('bread', $this->$menus['bread']); // 面包输出

        return $this->view->fetch($template ?: '', $value ?: []);
    }

    protected function getMenus()
    {
        $menus = $this->app->model('AuthRule', 'logic')->consoleMenu();
        return $menus;
    }

}
