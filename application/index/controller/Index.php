<?php
namespace app\index\controller;

use think\facade\Cache;

class Index
{
    public function index()
    {
        return view();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function test()
    {
        Cache::clear();
    }
}
