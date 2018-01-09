<?php
namespace app\index\controller;

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
        $detect = new \Mobile_Detect;
        // $extendPath = Env::get('extend_path');
        dump($detect->version('Edge'));
    }
}
