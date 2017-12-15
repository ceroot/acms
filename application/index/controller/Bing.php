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
use think\Controller;
use traits\controller\Jump;

class Bing extends Controller
{
    use Jump;

    protected $year; // 定义年
    protected $month; // 定义月
    protected $day; // 定义天
    protected $datesign; // 日期标记
    protected $tempPath; // 临时目录
    protected $basePath; // 基本目录，到月
    protected $savePath; // 保存目录，到天

    /**
     * [initialize 控制器初始化]
     */
    public function initialize()
    {
        $bingwallpaperPath = './data/bingwallpaper/'; // bing 目录
        $this->year        = date('Y');
        $this->month       = date('m');
        $this->day         = date('d');
        $this->datesign    = $this->year . $this->month . $this->day; // 日期标记赋值

        $this->tempPath = $bingwallpaperPath . 'temp/'; // 临时目录赋值
        $this->basePath = $bingwallpaperPath . $this->year . '/' . $this->month . '/'; // 基本目录赋值
        $this->savePath = $this->basePath . $this->day . '/'; // 保存目录赋值

        make_dir($this->basePath); // 创建保存目录
        make_dir($this->savePath); // 创建保存目录

    }
    public function index()
    {
        make_dir('D:/www/bingwallpaper/11');
        dump('bing');
    }

    public function test($type)
    {
        // 34a7TXEMBPE1Xj1tsVDsQPy2yAhTpNHhdlpoZRl4yPCOMc7z

        dump(authcode('getBing'));
        // deauthcode();
        // die;
        // // 判断参数
        // $type || $this->error('参数错误');

        if (deauthcode($type) != 'getBing') {
            $this->error('参数值错误');
        }
    }

    /**
     * [ getbingwallpapertest function_description ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T13:35:09+0800
     * @return   [type]                   [description]
     */
    public function getbingwallpapertest()
    {
        $data = QueryList::get('http://cn.bing.com/cnhp/life')->rules([
            'title'           => ['.hplaT .hplaTtl', 'text'],
            'country'         => ['.hplaT .hplaAttr', 'text'],
            'hplatt'          => ['.hplaCata .hplatt', 'text'],
            'hplats'          => ['.hplaCata .hplats', 'text'],
            'desc'            => ['.hplaCata #hplaSnippet', 'text'],

            'scenic0_title'   => ['.hplaCata .hplac:eq(0) .hplactt', 'text'],
            'scenic0_content' => ['.hplaCata .hplac:eq(0) .hplactc', 'text'],
            'scenic1_title'   => ['.hplaCata .hplac:eq(1) .hplactt', 'text'],
            'scenic1_content' => ['.hplaCata .hplac:eq(1) .hplactc', 'text'],
            'scenic2_title'   => ['.hplaCata .hplac:eq(2) .hplactt', 'text'],
            'scenic2_content' => ['.hplaCata .hplac:eq(2) .hplactc', 'text'],
            'scenic3_title'   => ['.hplaCata .hplac:eq(3) .hplactt', 'text'],
            'scenic3_content' => ['.hplaCata .hplac:eq(3) .hplactc', 'text'],

            'scenic4_title'   => ['.hplaCard:eq(0) .hplatt span', 'text'],
            'scenic4_desc'    => ['.hplaCard:eq(0) .hplats', 'text'],
            'scenic4_img'     => ['.hplaCard:eq(0) .rms_img', 'src'],
            'scenic4_content' => ['.hplaCard:eq(0) .hplatxt', 'text'],

            'scenic5_title'   => ['.hplaCard:eq(1) .hplatt span', 'text'],
            'scenic5_desc'    => ['.hplaCard:eq(1) .hplats', 'text'],
            'scenic5_img'     => ['.hplaCard:eq(1) .rms_img', 'src'],
            'scenic5_content' => ['.hplaCard:eq(1) .hplatxt', 'text'],
        ])->query()->getData();

        $ddd = $data->all();
        // $ddd = $ddd[0];
        dump($ddd);

        die;
        $path = 'C:\\Users\\veroo\\Desktop\\test\\' . time() . '.txt';
        file_put_contents($path, $ddd['text']);
        if (file_exists($path)) {
            echo 'ok';
        } else {
            echo 'ng';
        }
    }

    /**
     * [ getbingwallpaper 获取图片 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T13:35:23+0800
     * @return   [type]                   [加密后的类型，]
     */
    public function getbingwallpaper($type = null)
    {
        //b1a1xcodQ6629k8qRuFBowJn0eXRjcyCaZc2JaSdCC5GYi54//
        //dump(authcode('getBing'));

        // 判断参数
        if (!$type) {
            $this->error('参数错误');
        }

        (deauthcode($type) == 'getBing') || $this->error('参数值错误');

        // 获取 bing 图片数据
        $wallpaperData = $this->getWallpaperData();
        // dump($wallpaperData);

        // 验证数据
        $validate = validate('BingWallpaper');
        if (!$validate->check($wallpaperData)) {
            return $this->error($validate->getError());
        }

        // 获取景区数据
        $branchData = $this->getBranchData();

        // 数据组合
        $wallpaperData = array_merge($wallpaperData, $branchData['bing']);

        dump($wallpaperData);
        dump($branchData['brief']);
        dump($branchData['details']);

        // 数据写入
        $status = model('BingWallpaper')->save($wallpaperData);
        if ($status) {
            model('BingBranchBrief')->saveAll($branchData['brief']);
            model('BingBranchDetails')->saveAll($branchData['details']);
        }

    }

    /**
     * [ getWallpaperData 获取 bing 数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T13:37:36+0800
     * @param    integer                  $type [description]
     * @return   array                    $data [返回数组]
     */
    public function getWallpaperData($type = 0)
    {
        $sourcecode = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1'); // 采集网址

        $oldurl    = ''; // 原来 url 地址
        $oldurlbig = ''; // 原来 1920X1080 url 地址
        $titlelong = ''; // 长标题
        $author    = ''; // 作者
        $country   = 'CN'; // 国别

        // 匹配 url
        if (preg_match('/<url>(.+?)<\/url>/ies', $sourcecode, $matchesurl)) {
            $oldurl    = 'http://cn.bing.com' . $matchesurl[1];
            $oldurlbig = str_ireplace('1366x768', '1920x1080', $oldurl);
        }

        $picformat = '.' . pathinfo($oldurl, PATHINFO_EXTENSION); // 图片格式
        $oldname   = str_replace('/az/hprichbg/rb/', '', $matchesurl[1]); // 取得图片名称

        if (preg_match('/<copyright>(.+?)<\/copyright>/ies', $sourcecode, $matchesremark)) {
            $titlelong = $matchesremark[1]; // 长标题
        }

        if (preg_match('/\((.+?)\)/', $titlelong, $matcheauthor)) {
            $authorArr = explode('©', $matcheauthor[1]);
            $author    = trim($authorArr[1]); // 取得作者
        }

        $title = trim(preg_replace('/\((.*)\)/', '', $titlelong)); // 去掉小括号里的内容和前后的空格

        // 取得描述（已经取不到了）
        $description = '';
        if (preg_match_all('/<hotspot>(.+?)<\/hotspot>/ies', $sourcecode, $matcheshotspot)) {
            $hotspot = $matcheshotspot[1];
            $count   = count($hotspot);

            for ($i = 0; $i < $count; $i++) {
                if (preg_match_all('/<desc>(.+?)<\/desc>/ies', $hotspot[$i], $matchesdesc)) {
                    $descArr = $matchesdesc[1];
                    $description .= $descArr[0];
                }
                if (preg_match_all('/<query>(.+?)<\/query>/ies', $hotspot[$i], $matchesquery)) {
                    $queryArr = $matchesquery[1];
                    $desc .= $queryArr[0];
                }
            }

        }

        $savepathbig   = $this->basePath . '1920X1080/'; // 保存路径
        $savepathcnbig = $this->basePath . '/1920X1080_cn/'; // 保存路径
        make_dir($savepathbig);
        make_dir($savepathcnbig);

        $_day          = date('Y-m-d'); // 有年有月有日
        $filenamebig   = 'BingWallpaper-1920x1080-' . $_day . $picformat;
        $filenamecnbig = 'BingWallpaper-1920x1080-' . $_day . '（' . $title . '）' . $picformat; // 图片名称（有中文说明）

        $filename     = trim(str_replace('_1366x768', '', $oldname)); // 去掉名称中有 _1366x768
        $newname      = mb_convert_encoding($filename, 'UTF-8', 'auto'); // 文件名编码转换
        $newnamebig   = mb_convert_encoding($filenamebig, 'UTF-8', 'auto'); // 文件名编码转换
        $newnamecnbig = mb_convert_encoding($filenamecnbig, 'GB2312', 'auto'); // 文件名编码转换

        if ($type) {
            echo 'oldurl：' . $oldurl; // 原 url
            echo '<br/><br/>';
            echo 'oldurl：' . $oldurlbig; // 原 url
            echo '<br/><br/>';
            echo 'oldname：' . $oldname; // 原名称
            echo '<br/><br/>';
            echo 'picformat：' . $picformat;
            echo '<br/><br/>';
            echo 'titlelong：' . $titlelong;
            echo '<br/><br/>';
            echo 'author：' . $author;
            echo '<br/><br/>';
            echo 'title：' . $title; // 图片标题
            echo '<br/><br/>';
            echo 'description' . $description; // 图片描述
            echo '<br/><br/>';
            echo 'year：' . $this->year;
            echo '<br/><br/>';
            echo 'month：' . $this->month;
            echo '<br/><br/>';
            echo 'country：' . $country;
            echo '<br/><br/>';
            echo 'datesign：' . $this->datesign;
            echo '<br/><br/>';
            echo 'newname：' . $newname;
            echo '<br/><br/>';
            echo 'newnamebig：' . $newnamebig;
            echo '<br/><br/>';
            echo 'newnamecnbig：' . $newnamecnbig;
            echo '<br/><br/>';
        }

        // 执行保存并返回保存图像的路径
        $bigImgPath = $this->save_pic($oldurlbig, $newname, $this->savePath);

        if (is_file($bigImgPath)) {
            $image = \think\Image::open($bigImgPath); // 实例化图像
            $image->save($savepathbig . $newnamebig); // 保存 1920 X 1080
            $image->save($savepathcnbig . $newnamecnbig); // 保存 1920 X 1080 带中文
            $image->thumb(640, 640)->save($this->savePath . 'thumb-' . $newname); // 缩略图本地开始
        }

        $data['datesign']    = $this->datesign;
        $data['year']        = $this->year;
        $data['month']       = $this->month;
        $data['oldname']     = $oldname;
        $data['newname']     = $newname;
        $data['title']       = $title;
        $data['titlelong']   = $titlelong;
        $data['author']      = $author;
        $data['description'] = $description;
        $data['oldurl']      = $oldurl;
        $data['country']     = $country;

        return $data;
    }

    /**
     * [ getBranchData 获得单个图像 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T15:19:51+0800
     * @param    integer                  $type [description]
     * @return   [type]                         [description]
     */
    public function getBranchData($type = 0)
    {
        // 使用 QueryList 取得数据
        $data = QueryList::get('http://cn.bing.com/cnhp/life')->rules([
            'hplaTtl'              => ['#hplaT .hplaTtl', 'text'],
            'hplaAttr'             => ['#hplaT .hplaAttr', 'text'],
            'hplatt'               => ['.hplaCata .hplatt', 'text'],
            'hplats'               => ['.hplaCata .hplats', 'text'],

            'description'          => ['.hplaCata #hplaSnippet', 'text'],

            'brief0_title'         => ['.hplaCata .hplac:eq(0) .hplactt', 'text'],
            'brief0_description'   => ['.hplaCata .hplac:eq(0) .hplactc', 'text'],
            'brief1_title'         => ['.hplaCata .hplac:eq(1) .hplactt', 'text'],
            'brief1_description'   => ['.hplaCata .hplac:eq(1) .hplactc', 'text'],
            'brief2_title'         => ['.hplaCata .hplac:eq(2) .hplactt', 'text'],
            'brief2_description'   => ['.hplaCata .hplac:eq(2) .hplactc', 'text'],
            'brief3_title'         => ['.hplaCata .hplac:eq(3) .hplactt', 'text'],
            'brief3_description'   => ['.hplaCata .hplac:eq(3) .hplactc', 'text'],

            'details0_title'       => ['.hplaCard:eq(0) .hplatt span', 'text'],
            'details0_resume'      => ['.hplaCard:eq(0) .hplats', 'text'],
            'details0_img'         => ['.hplaCard:eq(0) .rms_img', 'src'],
            'details0_description' => ['.hplaCard:eq(0) .hplatxt', 'text'],
            'details1_title'       => ['.hplaCard:eq(1) .hplatt span', 'text'],
            'details1_resume'      => ['.hplaCard:eq(1) .hplats', 'text'],
            'details1_img'         => ['.hplaCard:eq(1) .rms_img', 'src'],
            'details1_description' => ['.hplaCard:eq(1) .hplatxt', 'text'],

        ])->query()->getData();

        $scenic = $data->all(); // 取得数据
        // dump($scenic);

        // 基本数据
        $bing['item_ttl']    = $scenic[0]['hplaTtl'];
        $bing['item_attr']   = $scenic[0]['hplaAttr'];
        $bing['item_tt']     = $scenic[0]['hplatt'];
        $bing['item_ts']     = $scenic[0]['hplats'];
        $bing['description'] = $scenic[0]['description'];

        // 简单数据
        $brief[0]['datesign']    = $this->datesign;
        $brief[0]['title']       = $scenic[0]['brief0_title'];
        $brief[0]['description'] = $scenic[0]['brief0_description'];
        $brief[1]['datesign']    = $this->datesign;
        $brief[1]['title']       = $scenic[0]['brief1_title'];
        $brief[1]['description'] = $scenic[0]['brief1_description'];
        $brief[2]['datesign']    = $this->datesign;
        $brief[2]['title']       = $scenic[0]['brief2_title'];
        $brief[2]['description'] = $scenic[0]['brief2_description'];
        $brief[3]['datesign']    = $this->datesign;
        $brief[3]['title']       = $scenic[0]['brief3_title'];
        $brief[3]['description'] = $scenic[0]['brief3_description'];

        $imgOld1 = $scenic[1]['details0_img']; // 取得图片 url
        $imgOld2 = $scenic[1]['details1_img']; // 取得图片 url

        $detailsName1 = md5(microtime() . $imgOld1) . '.jpg'; // 图片名称带后缀
        $detailsName2 = md5(microtime() . $imgOld2) . '.jpg'; // 图片名称带后缀

        $img1 = $this->save_pic($imgOld1, $detailsName1, $this->tempPath); // 执行临时文件保存操作
        $img2 = $this->save_pic($imgOld2, $detailsName2, $this->tempPath); // 执行临时文件保存操作

        // 图片1迁移
        if (is_file($img1)) {
            $image = \think\Image::open($img1);
            $image->save($this->savePath . $detailsName1);
            unlink($img1);
        }

        // 图片2迁移
        if (is_file($img2)) {
            $image = \think\Image::open($img2);
            $image->save($this->savePath . $detailsName2);
            unlink($img2);
        }

        // 详情数据
        $details[0]['datesign']    = $this->datesign;
        $details[0]['title']       = $scenic[0]['details0_title'];
        $details[0]['resume']      = $scenic[0]['details0_resume'];
        $details[0]['img']         = $detailsName1;
        $details[0]['imgold']      = $scenic[1]['details0_img'];
        $details[0]['description'] = $scenic[0]['details0_description'];
        $details[1]['datesign']    = $this->datesign;
        $details[1]['title']       = $scenic[0]['details1_title'];
        $details[1]['resume']      = $scenic[0]['details1_resume'];
        $details[1]['img']         = $detailsName2;
        $details[1]['imgold']      = $scenic[1]['details1_img'];
        $details[1]['description'] = $scenic[0]['details1_description'];

        // 数据组合
        $reData['bing']    = $bing;
        $reData['brief']   = $brief;
        $reData['details'] = $details;

        if ($type) {
            dump($reData);
        }
        return $reData;

    }

    //然后将几个函数组合，在函数save_pic()中调用，最后返回保存后的图片路径。
    /*
     * 参数:
    @string: $url 文件远程url;
    @string: $picName 保存文件名称;
    @string: $savepath 文件保存路径;
     */
    /**
     * [ save_pic 后将几个函数组合，在函数save_pic()中调用，最后返回保存后的图片路径 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:18:34+0800
     * @param    string                   $url      [文件远程url]
     * @param    string                   $picName  [保存文件名称]
     * @param    string                   $savepath [文件保存路径]
     * @return   string                   filepath  [返回图片路径]
     */
    private function save_pic($url, $picName, $savepath = '')
    {
        //处理地址
        $url = trim($url);
        $url = str_replace(' ', '%20', $url);
        //读文件
        $string = $this->read_filetext($url);

        if (empty($string)) {
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

    /**
     * [ read_filetext 取得图片内容。使用fopen打开图片文件，然后fread读取图片文件内容 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:20:47+0800
     * @param    [type]                   $filepath [文件路径]
     * @return   [type]                             [description]
     */
    private function read_filetext($filepath)
    {

        $filepath = trim($filepath);
        $htmlfp   = @fopen($filepath, 'r');
        $string   = '';

        //远程
        if (strstr($filepath, '://')) {
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

    /**
     * [ write_filetext 写文件，将图片内容fputs写入文件中，即保存图片文件 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:21:30+0800
     * @param    [type]                   $filepath [文件路径]
     * @param    [type]                   $string   [description]
     * @return   [type]                             [description]
     */
    private function write_filetext($filepath, $string)
    {
        if (file_exists($filepath)) {
            //echo '文件已经存在！</br>';
            //picInfo($filepath);
        } else {
            $fp = @fopen($filepath, 'w');
            @fputs($fp, $string);
            @fclose($fp);
            //echo '[OK]..!<br />';
            //picInfo($filepath);
        }
    }

    /**
     * [ get_filename 获取图片名称，也可以自定义要保存的文件名 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:22:37+0800
     * @param    [type]                   $filepath [文件路径]
     * @return   [type]                             [description]
     */
    private function get_filename($filepath)
    {
        $fr    = explode('/', $filepath);
        $count = count($fr) - 1;
        return $fr[$count];
    }

    /**
     * [ getSuffix 获取文件后缀名 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:23:48+0800
     * @param    [type]                   $filepath [文件路径]
     * @return   [type]                             [description]
     */
    private function getSuffix($filepath)
    {
        $fr    = explode('/', $filepath);
        $count = count($fr) - 1;
        $fr    = $fr[$count];
        $fr    = explode('.', $fr);
        $count = count($fr) - 1;
        return end($fr);
    }

    /**
     * [ picInfo 获取文件信息 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T16:24:07+0800
     * @param    [type]                   $filepath [文件路径]
     * @return   [type]                             [description]
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
