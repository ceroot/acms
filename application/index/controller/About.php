<?php
namespace app\index\controller;

use \OtherNS\A;
use \OtherNS\C;
use \OtherNS\D;

class About
{

    public function index()
    {
        // dump('about');
        return view();
    }

    public function indexTest()
    {
        $a = new A();
        $b = new C();
        $d = new D();

    }

    public function index_vest()
    {

    }
}
