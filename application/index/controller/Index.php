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

    public function test(){
    	$i = input('i');
    	$w = input('w');

    	// $image = './data/bingwallpaper/2017/12/19/ReindeerLichen_ZH-CN9944307835.jpg';

    	$image = './data/bingwallpaper/2017/12/19/'.$i;
    	// $image = 'https://www.benweng.com/data/bingwallpaper/2017/12/20/PowysCounty_ZH-CN11115693548.jpg';

    	$max_width = $w;//200;
		$max_height = 200;
		 
		$size = getimagesize($image);   //得到图像的大小
		$width = $size[0];             
		$height = $size[1];
		 
		$x_ratio = $max_width / $width;
		$y_ratio = $max_height / $height;
		 
		if (($width <= $max_width) && ($height <= $max_height))
		{
		    $tn_width = $width;
		    $tn_height = $height;
		}
		elseif (($x_ratio * $height) < $max_height)
		{
		    $tn_height = ceil($x_ratio * $height);
		    $tn_width = $max_width;
		}
		else
		{
		    $tn_width = ceil($y_ratio * $width);
		    $tn_height = $max_height;
		}

    	$src = imagecreatefromjpeg($image);
		$dst = imagecreatetruecolor($tn_width, $tn_height); //新建一个真彩色图像
		imagecopyresampled($dst, $src, 0, 0, 0, 0,$tn_width, $tn_height, $width, $height);        //重采样拷贝部分图像并调整大小
		header('Content-Type: image/jpeg');
		imagejpeg($dst,null,100);
		imagedestroy($src);
		imagedestroy($dst);

		die;
    }
}
