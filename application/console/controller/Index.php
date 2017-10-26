<?php
namespace app\console\controller;

use app\console\controller\Base;
use think\facade\App;

class Index extends Base
{

    /**
     * @Author    Hybrid
     * @DateTime  2017-10-20
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function index()
    {
        // $this->app->view->assign('dd', 'dd');
        return $this->setView();

    }

    public function hello()
    {
        dump('hello');
    }
}
