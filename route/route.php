<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

// Route::rule('my', 'Member/myinfo'); // 静态地址路由

Route::rule('document$', 'index/Document/index');
Route::rule('document/lists', 'index/Document/lists');
Route::rule('document/lists/:id', 'index/Document/lists');
Route::rule('document/reader/:id', 'index/Document/reader');
// Route::rule('document/category/:time', 'index/Document/lists');

Route::rule('bing$', 'index/Bing/index');
Route::rule('bing/details/:id', 'index/Bing/details');
Route::rule('bing/download/:id', 'index/Bing/download');
Route::rule('new/:id', 'index/News/read');
Route::rule('about', 'index/About/index');
// Route::domain('console', 'console');

// Route::domain('bing', function () {
//     // 动态注册域名的路由规则
//     Route::rule('details/:id', 'index/Bing/details');
//     Route::rule('download/:id', 'index/Bing/download');
//     Route::bind('index/Bing');
// });

// Route::domain('bing', '\app\index\controller\Bing');

Route::rule('resize', function ($i, $w) {
    $image = deauthcode($i); // 解密
    // $image = 'https://www.benweng.com/data/bingwallpaper/2017/12/20/PowysCounty_ZH-CN11115693548.jpg';

    if (!$image) {
        return '参数错误';
    }

    if ($w < 67) {
        return '参数错误w';
    }

    if (!file_exists($image)) {
        return '文件错误';
    }

    $size   = getimagesize($image); // 得到图像的大小
    $width  = $size[0];
    $height = $size[1];

    $ratio = $width / $height; // 长高比

    $max_width  = $w; //200;
    $max_height = $w / $ratio; //200;

    $x_ratio = $max_width / $width;
    $y_ratio = $max_height / $height;

    if (($width <= $max_width) && ($height <= $max_height)) {
        $tn_width  = $width;
        $tn_height = $height;
    } elseif (($x_ratio * $height) < $max_height) {
        $tn_height = ceil($x_ratio * $height);
        $tn_width  = $max_width;
    } else {
        $tn_width  = ceil($y_ratio * $width);
        $tn_height = $max_height;
    }

    $src = imagecreatefromjpeg($image);
    $dst = imagecreatetruecolor($tn_width, $tn_height); //新建一个真彩色图像
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height); //重采样拷贝部分图像并调整大小
    header('Content-Type: image/jpeg');
    imagejpeg($dst, null, 100);
    imagedestroy($src);
    imagedestroy($dst);

});

return [

];
