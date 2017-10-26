<?php
namespace app\console\controller;

use app\console\traits\Admin;
use think\Controller;

class Base extends Controller
{
    use Admin;

    public $model;
    public $pk;
    public $id;
    public $menu;

    /**
     * @name   _initialize          [初始化]
     * @author SpringYang <ceroot@163.com>
     */
    public function initialize()
    {
        // parent::initialize();

        //dump(request()->ip());die;
        // $authModel = cache('instantiation_controller');
        // // dump($authModel);die;
        // // 判断是否需要实例化的控制器
        // if (in_array(strtolower(toUnderline(request()->controller())), $authModel)) {
        //     $this->model = model(request()->controller()); // 实例化控制器
        //     $this->pk    = $this->model->getPk(); // 取得主键字段名
        //     $this->id    = deauthcode(input($this->pk)); // id解密

        // }

        // // 菜单输出
        // $this->menu = model('AuthRule', 'logic')->consoleMenu();

        // $this->assign('menu', $this->menu); // 一级菜单输出
        // $this->assign('second', $this->menu['second']); // 二级菜单输出
        // $this->assign('title', $this->menu['showtitle']); // 标题输出
        // $this->assign('bread', $this->menu['bread']); // 面包输出

    }
}
