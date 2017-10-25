<?php
namespace app\console\controller;

use think\facade\App;

class Index
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
        $data = App::model('manager')->select();
        dump($data);
        // return $this->setView('fds');

    }
}
