<?php
namespace app\index\controller;

use think\facade\Log;

class Index
{
    public function index()
    {
        return '5.1 RC2';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    // 空操作
    public function _empty($name)
    {
        //把所有空操作解析到 showAction 方法
        return $this->showAction($name);
    }

    //注意 showAction 方法 本身是 protected 方法
    protected function showAction($name)
    {
        Log::record('[ 空方法 ]：' . $name . '此方法不存在');
        //和$name这个城市相关的处理
        return '当前操作方法不存在，操作方法名为：' . $name;
    }
}
