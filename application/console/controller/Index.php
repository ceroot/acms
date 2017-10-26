<?php
namespace app\console\controller;

use app\console\controller\Base;
use app\console\traits\Admin;
use think\facade\App;

class Index extends Base
{
    use Admin;

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
        $data = App::model('manager')->select();
        dump($data);
        return $this->setView('index', 'index');

    }

    public function hello()
    {
        dump('hello');
    }
}
