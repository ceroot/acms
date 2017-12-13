<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Bing.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-12-13 14:53:41
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\index\controller;

use QL\QueryList;
use think\Db;
use traits\controller\Jump;

class Bing
{
    use Jump;

    public function index()
    {
        make_dir('D:/www/bingwallpaper/11');
        dump('bing');
    }

    public function getbingwallpapertest()
    {
        // $sourcecode = file_get_contents('http://cn.bing.com'); // 采集网址
        // dump($sourcecode);
        $data = QueryList::get('http://cn.bing.com/cnhp/life')->rules([
            'title'           => ['.hplaDMLink .hplaTtl', 'text'],
            'country'         => ['.hplaDMLink .hplaAttr', 'text'],
            'hplatt'          => ['.hplaCata .hplatt', 'text'],
            'hplats'          => ['.hplaCata .hplats', 'text'],
            'desc'            => ['.hplaCata #hplaSnippet', 'text'],

            'scenic0_title'   => ['.hplaCata .hplac:eq(0) .hplactt', 'text'],
            'Scenic0_content' => ['.hplaCata .hplac:eq(0) .hplactc', 'text'],
            'Scenic1_title'   => ['.hplaCata .hplac:eq(1) .hplactt', 'text'],
            'Scenic1_content' => ['.hplaCata .hplac:eq(1) .hplactc', 'text'],
            'Scenic2_title'   => ['.hplaCata .hplac:eq(2) .hplactt', 'text'],
            'Scenic2_content' => ['.hplaCata .hplac:eq(2) .hplactc', 'text'],
            'Scenic3_title'   => ['.hplaCata .hplac:eq(3) .hplactt', 'text'],
            'Scenic3_content' => ['.hplaCata .hplac:eq(3) .hplactc', 'text'],

            'scenic4_title'   => ['.hplaCard:eq(0) .hplatt span', 'text'],
            'scenic4_desc'    => ['.hplaCard:eq(0) .hplats', 'text'],
            'scenic4_img'     => ['.hplaCard:eq(0) .rms_img', 'src'],
            'scenic4_content' => ['.hplaCard:eq(0) .hplatxt', 'text'],

            'scenic5_title'   => ['.hplaCard:eq(1) .hplatt span', 'text'],
            'scenic5_desc'    => ['.hplaCard:eq(1) .hplats', 'text'],
            'scenic5_img'     => ['.hplaCard:eq(1) .rms_img', 'src'],
            'scenic5_content' => ['.hplaCard:eq(1) .hplatxt', 'text'],

            // 'text'  => ['#zoom', 'text', 'p', function ($content) {
            //     $content = strtolower($content);
            //     $pattern = "/<p[^>]*>([^\<|\>]*)<\/p>/is";
            //     preg_match_all($pattern, $content, $Html);
            //     // dump($Html[0]);
            //     $temp = '';
            //     foreach ($Html[0] as $value) {
            //         preg_match($pattern, $value, $p1);
            //         if (strpos($value, 'text-align: right')) {
            //             $temp .= '<p style="text-align:right;">' . $p1[1] . '</p>';
            //         } else {
            //             $temp .= '<p>' . $p1[1] . '</p>';
            //         }
            //     }
            //     return $temp;
            // }],
        ])->query()->getData();

        $ddd = $data->all();
        // $ddd = $ddd[0];
        dump($ddd);

        die;
        $path = "C:\\Users\\veroo\\Desktop\\test\\" . time() . ".txt";
        file_put_contents($path, $ddd['text']);
        if (file_exists($path)) {
            echo "ok";
        } else {
            echo "ng";
        }
    }

    public function getbingwallpaper()
    {
        $type = input('type');
        if (!$type) {
            $this->error('参数错误');
        }

        $sourcecode = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1'); // 采集网址

        if (preg_match("/<url>(.+?)<\/url>/ies", $sourcecode, $matchesurl)) {
            $oldurl = 'http://cn.bing.com' . $matchesurl[1];
            echo 'oldurl：' . $oldurl; // 原 url
            echo '<br/><br/>';
            $oldurlbig = str_ireplace('1366x768', '1920x1080', $oldurl);
            echo 'oldurl：' . $oldurlbig; // 原 url
            echo '<br/><br/>';
        }

        $oldname = str_replace("/az/hprichbg/rb/", "", $matchesurl[1]);
        echo 'oldname：' . $oldname; // 原名称
        echo '<br/><br/>';

        //$picformat    = strstr($oldname,'.');    // 图片格式
        $picformat = '.' . pathinfo($oldurl, PATHINFO_EXTENSION); // 图片格式
        echo 'picformat：' . $picformat;
        echo '<br/><br/>';

        if (preg_match("/<copyright>(.+?)<\/copyright>/ies", $sourcecode, $matchesremark)) {
            $remark = $matchesremark[1]; // 图片标题（有作者）
            echo 'remark：' . $remark;
            echo '<br/><br/>';
        }

        $title = trim(preg_replace("/\((.*)\)/", "", $remark)); // 去掉小括号里的内容和前后的空格
        echo 'title：' . $title; // 图片标题
        echo '<br/><br/>';

        $desc = '';
        if (preg_match_all("/<hotspot>(.+?)<\/hotspot>/ies", $sourcecode, $matcheshotspot)) {
            $hotspot = $matcheshotspot[1];
            $count   = count($hotspot);

            for ($i = 0; $i < $count; $i++) {
                if (preg_match_all("/<desc>(.+?)<\/desc>/ies", $hotspot[$i], $matchesdesc)) {
                    $descArr = $matchesdesc[1];
                    $desc .= $descArr[0];
                }
                if (preg_match_all("/<query>(.+?)<\/query>/ies", $hotspot[$i], $matchesquery)) {
                    $queryArr = $matchesquery[1];
                    $desc .= $queryArr[0];
                }
            }
            echo 'desc：' . $desc; // 图片描述
            echo '<br/><br/>';
        }

        $year = date('Y'); // 年
        echo 'year：' . $year;
        echo '<br/><br/>';
        $month = date('m'); // 月
        echo 'month：' . $month;
        echo '<br/><br/>';
        $country = 'CN'; // 国别
        echo 'country：' . $country;
        echo '<br/><br/>';
        $addtime = date('Y-m-d H:m:s'); // 取得当前时间

        echo 'addtime：' . $addtime;
        echo '<br/><br/>';
        $addtime = strtotime($addtime);
        echo 'strtotime：' . $addtime;
        echo '<br/><br/>';

        // $basepath       = '/home/wwwroot/ceroot/domain/bing/web/wallpaper/' . $year . $month . '/';
        $basepath = 'D:/www/bingwallpaper/' . $year . $month . '/';

        $savepath      = $basepath; // 保存路径
        $savepathbig   = $basepath . '1920X1080/'; // 保存路径
        $savepathcn    = $basepath . 'cn/'; // 保存路径
        $savepathcnbig = $basepath . 'cn/1920X1080/'; // 保存路径

        $day           = date('Y-m-d'); // 有年有月有日
        $filename      = 'BingWallpaper-' . $day . $picformat; // 图片名称
        $filenamebig   = 'BingWallpaper-1920x1080-' . $day . $picformat;
        $filenamecn    = 'BingWallpaper-' . $day . '（' . $title . '）' . $picformat; // 图片名称（有中文说明）
        $filenamecnbig = 'BingWallpaper-1920x1080-' . $day . '（' . $title . '）' . $picformat;

        $newname      = mb_convert_encoding($filename, "UTF-8", "auto"); // 文件名编码转换
        $newnamebig   = mb_convert_encoding($filenamebig, "UTF-8", "auto"); // 文件名编码转换
        $newnamecn    = mb_convert_encoding($filenamecn, "GB2312", "auto"); // 文件名编码转换
        $newnamecnbig = mb_convert_encoding($filenamecnbig, "GB2312", "auto"); // 文件名编码转换

        echo 'newname：' . $newname;
        echo '<br/><br/>';
        echo 'newnamebig：' . $newnamebig;
        echo '<br/><br/>';
        echo 'newnamecn：' . $newnamecn;
        echo '<br/><br/>';
        echo 'newnamecnbig：' . $newnamecnbig;
        echo '<br/><br/>';
        // die;
        // 执行保存
        $this->get_pic($oldurl, $newname, $savepath);
        $this->get_pic($oldurlbig, $newnamebig, $savepathbig);
        $this->get_pic($oldurl, $newnamecn, $savepathcn);
        $this->get_pic($oldurlbig, $newnamecnbig, $savepathcnbig);

        // 缩略图本地开始
        $savepaththumb = $basepath . 'thumb/'; // 缩略图保存路径
        make_dir($savepaththumb);

        $type = strtolower(pathinfo($oldurl, PATHINFO_EXTENSION));
        //$name        = strtolower(basename($oldurl));
        //$name        = $filename;
        $dstpath = $savepaththumb;
        $dstimg  = $dstpath . 'thumb-' . $day . $picformat;

        $resize_width  = 280;
        $resize_height = 165;
        $cut           = 0;
        $quality       = 90;

        $imgInfo = getimagesize($oldurl);
        $width   = $imgInfo[0];
        $height  = $imgInfo[1];
        $im      = '';

        $resize_ratio = $resize_width / $resize_height; // 改变后的图象的比例
        $ratio        = $width / $height; // 实际图象的比例

        if ($type == 'jpg' || $type == 'jpeg') {
            $im = imagecreatefromjpeg($oldurl);
        }
        if ($type == 'gif') {
            $im = imagecreatefromgif($oldurl);
        }
        if ($type == 'png') {
            $im = imagecreatefrompng($oldurl);
        }
        if ($type == 'wbm') {
            $im = imagecreatefromwbmp($oldurl);
        }
        if ($type == 'bmp') {
            //$im=ImageCreateFromBMP($oldurl);
        }
        //$im        = imagecreatefromjpeg($url);

        if ($cut == 1) {
            if ($img_func === 'imagepng' && (str_replace('.', '', PHP_VERSION) >= 512)) {
                //针对php版本大于5.12参数变化后的处理情况
                $quality = 9;
            }
            if ($ratio >= $resize_ratio) {
                //高度优先
                $newimg = imagecreatetruecolor($resize_width, $resize_height);
                imagecopyresampled($newimg, $tim, 0, 0, 0, 0, $resize_width, $tresize_height, (($height) * $resize_ratio), $height);
                imagejpeg($newimg, $dstimg, $quality);
            }
            if ($ratio < $resize_ratio) {
                //宽度优先
                $newimg = imagecreatetruecolor($resize_width, $resize_height);
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
                imagejpeg($newimg, $dstimg, $quality);
            }
        } else {
            if ($ratio >= $resize_ratio) {
                $newimg = imagecreatetruecolor($resize_width, $resize_width / $ratio);
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_width / $ratio, $width, $height);
                imagejpeg($newimg, $dstimg, $quality);
            } else {
                $newimg = imagecreatetruecolor($resize_height * $ratio, $resize_height);
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_height * $ratio, $resize_height, $width, $height);
                imagejpeg($newimg, $dstimg, $quality);
            }
        }

        $data['oldname'] = $oldname;
        $data['newname'] = $newname;
        $data['title']   = $title;
        $data['remark']  = $remark;
        $data['desc']    = $desc;
        $data['oldurl']  = $oldurl;
        $data['year']    = $year;
        $data['month']   = $month;
        $data['addtime'] = $addtime;
        $data['country'] = $country;

        Db::name('bingwallpaper')->insert($data);

    }

    private function get_pic($cont, $picName, $path)
    {
        $this->save_pic($cont, $picName, $path); //下载并保存图片
    }

    //然后将几个函数组合，在函数save_pic()中调用，最后返回保存后的图片路径。
    /*
     * 参数:
    @string: $url 文件远程url;
    @string: $picName 保存文件名称;
    @string: $savepath 文件保存路径;
     */
    private function save_pic($url, $picName, $savepath = '')
    {
        //处理地址
        $url = trim($url);
        $url = str_replace(" ", "%20", $url);
        //读文件
        $string = $this->read_filetext($url);

        if (empty($string)) {
            $this->get_pic();
            //echo '读取不了文件';exit;
        }

        //文件名
        //$filename = get_filename($url);
        $filename = $picName;
        //echo $filename;
        //存放目录

        make_dir($savepath); //建立存放目录
        //文件地址
        $filepath = $savepath . $filename;
        //写文件
        $this->write_filetext($filepath, $string);
        return $filepath;
    }

    //函数read_filetext()取得图片内容。使用fopen打开图片文件，然后fread读取图片文件内容。
    /*
     * 参数:
    @string: $filepath 文件路径;
     */
    private function read_filetext($filepath)
    {

        $filepath = trim($filepath);
        $htmlfp   = @fopen($filepath, "r");
        $string   = '';

        //远程
        if (strstr($filepath, "://")) {
            while ($data = @fread($htmlfp, 500000)) {
                $string .= $data;
            }

        } else {
//本地
            $string = @fread($htmlfp, @filesize($filepath));
        }

        @fclose($htmlfp);
        return $string;
    }

    //函数write_filetext()写文件，将图片内容fputs写入文件中，即保存图片文件。
    /*
     * 参数:
    @string: $filepath 文件路径;
     */
    private function write_filetext($filepath, $string)
    {
        if (file_exists($filepath)) {
            //echo "文件已经存在！</br>";
            //picInfo($filepath);
        } else {
            $fp = @fopen($filepath, "w");
            @fputs($fp, $string);
            @fclose($fp);
            //echo "[OK]..!<br />";
            //picInfo($filepath);
        }
    }

    //函数get_filename()获取图片名称，也可以自定义要保存的文件名。
    /*
     * 参数:
    @string: $filepath 文件路径;
     */
    private function get_filename($filepath)
    {
        $fr    = explode("/", $filepath);
        $count = count($fr) - 1;
        return $fr[$count];
    }

    //函数getSuffix()获取文件后缀名
    /*
     * 参数:
    @string: $filepath 文件路径;
     */
    private function getSuffix($filepath)
    {
        $fr    = explode("/", $filepath);
        $count = count($fr) - 1;
        $fr    = $fr[$count];
        $fr    = explode(".", $fr);
        $count = count($fr) - 1;
        return end($fr);
    }

    //函数picInfo()获取文件信息
    /*
     * 参数:
    @string: $filepath 文件路径;
     */
    private function picInfo($filepath)
    {
        if (!$filepath == '') {
            $fileName1 = realpath($filepath);
            $size      = getimagesize($fileName1);
            print_r($size);
        }
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
