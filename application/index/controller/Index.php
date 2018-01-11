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
        $dd = is_images_url('http://img1.mydrivers.com/img/20180111/s_fca9e42f7bfd465294c34b1db020a6ba.jpg');
        dump($dd);
        // die;

        $strr = '<p style="text-align: center;"><img class="dd" alt="苹果突然关闭老款iPhone系统降级通道" src="/data/images/20180111/90b590af692a68777cec5791b09832fc446953.jpg" style="border-color: black; border-style: solid; border-width: 1px;" title="苹果突然关闭老款iPhone系统降级通道"></p><p style="text-align: center;"><img alt="苹果突然关闭老款iPhone系统降级通道" src="/data/images/20180111/90b590af692a68777cec5791b09832fc446953.jpg" style="border-color: black; border-style: solid; border-width: 1px;" title="苹果突然关闭老款iPhone系统降级通道"></p>';
        // $str = preg_replace("/<img\s*src=(\"|\')(.*?)\\1[^>]*/is", '<img src="$2" />', $str);
        dump($strr);
        // $str = preg_replace('/(<img).+(src=\"?.+)images\/(.+\.(jpg|gif|bmp|bnp|png)\"?).+>/i', "\${1} \${2}uc/images/\${3}>", $str);
        $str = preg_replace('/(<img).+(src=\"?.+)\/(.+\.(jpg|gif|bmp|bnp|png)\"?).+>/i', "\${1} \${2}/\${3}>", $strr);
        dump($str);

        $search = '/(<img.*?)style=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
        $str    = preg_replace($search, '$1$3', $strr);
        dump($str);

        die;
        $detect = new \Mobile_Detect;
        // $extendPath = Env::get('extend_path');
        dump($detect->version('Edge'));
    }
}
