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

class Bingg extends Controller
{
    use Jump;

    protected $batchValidate = true; // 是否批量验证

    protected $year; // 定义年
    protected $month; // 定义月
    protected $day; // 定义天
    protected $datesign; // 日期标记
    protected $tempPath; // 临时目录
    protected $basePath; // 基本目录，到月
    protected $savePath; // 保存目录，到天
    protected $bingwallpaperPath; // bing 目录

    /**
     * [initialize 控制器初始化]
     */
    public function initialize()
    {
        $this->year     = date('Y');
        $this->month    = date('m');
        $this->day      = date('d');
        $this->datesign = $this->year . $this->month . $this->day; // 日期标记赋值

        $this->bingwallpaperPath = './data/bingtest/'; // bing 目录
        $this->tempPath          = $this->bingwallpaperPath . 'temp/'; // 临时目录赋值
        $this->basePath          = $this->bingwallpaperPath . $this->year . '/' . $this->month . '/'; // 基本目录赋值
        $this->savePath          = $this->basePath . $this->day . '/'; // 保存目录赋值

        make_dir($this->basePath); // 创建保存目录
        make_dir($this->savePath); // 创建保存目录

    }

    public function test()
    {
        $url = 'http://cn.bing.com/az/hprichbg/rb/PowysCounty_ZH-CN11115693548_1366x768.jpg';
        dump(parse_url($url, PHP_URL_PATH));
        dump(pathinfo(parse_url($url, PHP_URL_PATH)));
        echo pathinfo(parse_url($url)['path'])['extension'];

        echo pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

        die;

    }

    public function dd(){
        $_m = 10;
        $where = [
            'year' => 2014,
            'month' => 9
        ];
        $data = db('old')->where($where)->select();
        // dump($data);
        // die;
        $newdata = [];
        foreach ($data as $value) {
            $imgName = $value['newname'];
            $oldname = $value['oldname'];
            $newname = str_ireplace('1366x768', '', $oldname);
            
            $tempArr['imgName']=$imgName;
            $date = str_ireplace('BingWallpaper-', '', $imgName);
            $date = str_ireplace('.jpg', '', $date);
            $strtotime = strtotime($date);

            $datesign = date('Ymd',$strtotime);

            $id = model('BingWallpaper')->getFieldByDatesign($datesign, 'id');

            $tempArr['datesign'] = $datesign;
            $tempArr['id'] = $id;
            $tempArr['oldname'] = $oldname;
            $tempArr['newname'] = $newname;
            $tempArr['oldurl'] = $value['oldurl'];

            $imgPath = './data/'.$imgName;
            $strtotime = strtotime($datesign);

            if (is_file($imgPath)) {
                $_savepath = $this->bingwallpaperPath . '/' . date('Y', $strtotime) . '/' . date('m', $strtotime) . '/' . date('d', $strtotime) . '/';
                make_dir($_savepath);

                copy($imgPath,$_savepath . $imgName);
                $image = \think\Image::open($imgPath);
                $image->thumb(640, 640)->save($_savepath . 'thumb-' . $newname); // 缩略图本地开始
            }

            $newdata[] = $tempArr;
            # code...
        }

        dump($newdata);
        //model('BingWallpaper')->saveAll($newdata);

    }

    public function saveRemoteFile($url, $picName, $savePath = '')
    {
        if (!$this->check_remote_file_exists($url)) {
            return false;
        };

        $fileContent = $this->url_get_content($url);
        make_dir($savePath);
        $saveFilePath = $savePath . $picName;
        $saveFile     = fopen($saveFilePath, 'w');
        fwrite($saveFile, $fileContent);
        fclose($saveFile);
        return $saveFilePath;
    }

    public function url_get_content($url)
    {
        if (function_exists("curl_init")) {
            $ch      = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        } else {
            $is_auf = ini_get('allow_url_fopen') ? true : false;
            if ($is_auf) {
                $file_contents = file_get_contents($url);
            }
        }
        return $file_contents;
    }

    public function check_remote_file_exists($url)
    {
        $curl = curl_init($url);
        // 不取回数据
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // 不加这个会返回403，加了才返回正确的200，原因不明

        // 发送请求
        $result = curl_exec($curl);
        $found  = false;
        // 如果请求没有发送失败
        if ($result !== false) {
            // 再检查http响应码是否为200
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $found = true;
            }
        }
        curl_close($curl);

        return $found;
    }

    public function index()
    {
        // dump('bing');
        $data    = model('BingWallpaper')->order('datesign', 'desc')->paginate(12,'',[
            'type'     => '\page\Layui',
            'var_page' => 'page',
        ]);
        $newdata = [];
        foreach ($data as $value) {
            $datesign         = $value['datesign'];
            $value['brief']   = model('BingBranchBrief')->where('datesign', $datesign)->select();
            $value['details'] = model('BingBranchDetails')->where('datesign', $datesign)->select();
            $value['id']      = authcode($value['id']);
            $newdata[]        = $value;
        }

        $page = $data->render();

        $this->assign('list', $newdata);
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function details($id)
    {
        // dump('details');
        $id || $this->error('参数错误');
        $id = deauthcode($id);
        $id || $this->error('参数值错误');
		
		//dump($id);
        $model = model('BingWallpaper');
        $model->where('id', $id)->setInc('viewcount');

        $data            = $model->get($id);
		//dump($data);

        $datesign        = $data['datesign'];
        $data['brief']   = model('BingBranchBrief')->where('datesign', $datesign)->select();
        $data['details'] = model('BingBranchDetails')->where('datesign', $datesign)->select();

        //dump($data);
        $this->assign('data', $data);
        return $this->fetch();

    }
    public function curl_file_get_contents($durl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        // curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        // curl_setopt($ch, CURLOPT_REFERER, _REFERER_);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }

    public function getFor4ui($type = null)
    {
        // getFor4ui?type=b1a1xcodQ6629k8qRuFBowJn0eXRjcyCaZc2JaSdCC5GYi54
        //b1a1xcodQ6629k8qRuFBowJn0eXRjcyCaZc2JaSdCC5GYi54//
        //dump(authcode('getBing'));

        // 判断参数
        $type || $this->error('参数错误');

        (deauthcode($type) == 'getBing') || $this->error('参数值错误');

        set_time_limit(0);

        $url = 'https://www.4ui.cn/bing/1.html';

        $data = QueryList::get($url)
        // 设置采集规则
            ->rules([
                //采集a标签的href属性
                'link' => ['.list-wallpaper .caption a', 'href'],
                //采集a标签的text文本
                // 'link_text' => ['.list-wallpaper .caption a', 'text'],
            ])
            ->query()->getData();
        $data = $data->all();

        $newarr = [];
        foreach ($data as $value) {
            # code...
            $link = $value['link'];
            $link = 'https://www.4ui.cn' . $link;

            $rules = [
                //采集a标签的href属性
                'title'                => ['.page-header p', 'text'],
                'datesign'             => ['.page-header small', 'html', '', function ($small) {
                    $arr       = preg_split("/<i class=(.*?)><\/i>/", $small);
                    $strtotime = strtotime(trim($arr[1]));
                    $datesign  = date('Ymd', $strtotime);
                    return $datesign;
                }],
                'small'                => ['.page-header small', 'html', '', function ($small) {
                    $small = trim(str_replace('Images（图片来源于必应搜索）', '', $small));
                    $small = trim(str_replace('（图片来源于必应搜索）', '', $small));
                    $arr   = preg_split("/<i class=(.*?)><\/i>/", $small);

                    $redata = [];
                    // $redata['date']     = trim($arr[1]);
                    $redata['item_ttl'] = trim($arr[3]);
                    $redata['author']   = trim($arr[5]);
                    return $redata;
                }],
                'description'          => ['.bing-box .container .row p:eq(2)', 'text'],
                'brief0_title'         => ['.bing-box .container .row h3:eq(0)', 'text'],
                'brief0_description'   => ['.bing-box .container .row p:eq(3)', 'text'],
                'brief1_title'         => ['.bing-box .container .row h3:eq(1)', 'text'],
                'brief1_description'   => ['.bing-box .container .row p:eq(4)', 'text'],
                'brief2_title'         => ['.bing-box .container .row h3:eq(2)', 'text'],
                'brief2_description'   => ['.bing-box .container .row p:eq(5)', 'text'],
                'brief3_title'         => ['.bing-box .container .row h3:eq(3)', 'text'],
                'brief3_description'   => ['.bing-box .container .row p:eq(6)', 'text'],

                'details0_title'       => ['.bing-box .container .row h3:eq(4)', 'text', '-small'],
                'details0_resume'      => ['.bing-box .container .row h3:eq(4) small', 'text'],
                'details0_img'         => ['.bing-box .container .row p:eq(7) img', 'src'],
                'details0_description' => ['.bing-box .container .row p:eq(8)', 'text'],
                'details1_title'       => ['.bing-box .container .row h3:eq(5)', 'text', '-small'],
                'details1_resume'      => ['.bing-box .container .row h3:eq(5) small', 'text'],
                'details1_img'         => ['.bing-box .container .row p:eq(9) img', 'src'],
                'details1_description' => ['.bing-box .container .row p:eq(10)', 'text'],

            ];

            $data = QueryList::get($link)->rules($rules)->query()->getData();
            $data = $data->all();

            $newarr[] = $data;

        }
        // dump($newarr);die;

        $sortArr = [];
        foreach ($newarr as $value) {
            $sortArr[] = $value[0];
            // dump($value[0]);
        }

        // unset($sortArr[8]);
        // unset($sortArr[9]);
        // unset($sortArr[10]);
        // unset($sortArr[11]);
        // $sortArr = $this->f_order($sortArr, 'datesign', 1);
        //cache('data', $newarr);
        // die;
        // dump($sortArr);die;

        $bingData    = [];
        $briefData   = [];
        $detailsData = [];

        foreach ($sortArr as $value) {
            $small  = $value['small'];
            $author = $small['author'];

            $datesign = $value['datesign'];
            $dateTemp = strtotime($datesign);

            $bing['title']       = trim($value['title']);
            $bing['titlelong']   = trim($value['title']) . ' (© ' . $author . ')';
            $bing['description'] = trim($value['description']);
            $bing['author']      = $author;
            $bing['item_ttl']    = $small['item_ttl'];
            $bing['year']        = date('Y', $dateTemp);
            $bing['month']       = date('m', $dateTemp);
            $bing['datesign']    = $datesign;

            $bingData[] = $bing;

            $brief['datesign']     = $datesign;
            $brief['title0']       = $value['brief0_title'];
            $brief['description0'] = $value['brief0_description'];
            $brief['title1']       = $value['brief1_title'];
            $brief['description1'] = $value['brief1_description'];
            $brief['title2']       = $value['brief2_title'];
            $brief['description2'] = $value['brief2_description'];
            $brief['title3']       = $value['brief3_title'];
            $brief['description3'] = $value['brief3_description'];

            $briefData[] = $brief;

            $details['datesign']     = $datesign;
            $details['resume0']      = $value['details0_resume'];
            $details['title0']       = $value['details0_title'];
            $details['description0'] = $value['details0_description'];
            $details['img0']         = $value['details0_img'];
            $details['resume1']      = $value['details1_resume'];
            $details['title1']       = $value['details1_title'];
            $details['description1'] = $value['details1_description'];
            $details['img1']         = $value['details1_img'];

            $detailsData[] = $details;

        }

        dump($bingData);
        // die;

        // 验证数据
        // $validate = validate('BingWallpaper');
        // if (!$validate->check($bingData)) {
        //     return $this->error($validate->getError());
        // }
        // die;

        $briefTemp = [];
        foreach ($briefData as $value) {
            $_t = [];
            for ($i = 0; $i < 4; $i++) {
                $v['datesign']    = $value['datesign'];
                $v['title']       = $value['title' . $i];
                $v['description'] = $value['description' . $i];
                $briefTemp[]      = $v;
            }
        }
        dump($briefTemp);
        // die;

        $detailsTemp = [];
        foreach ($detailsData as $value) {
            $datesign  = $value['datesign'];
            $strtotime = strtotime($datesign);
            $_t        = [];
            for ($i = 0; $i < 2; $i++) {
                $v['datesign']    = $datesign;
                $v['title']       = $value['title' . $i];
                $v['resume']      = $value['resume' . $i];
                $v['description'] = $value['description' . $i];

                $imgUrl  = 'https://www.4ui.cn' . $value['img' . $i];
                $imgName = md5(microtime() . $imgUrl) . '.jpg';
                $imgPath = $this->saveRemoteFile($imgUrl, $imgName, $this->tempPath); // 执行临时文件保存操作

                // 图片1迁移
                if (is_file($imgPath)) {
                    $_savepath = $this->bingwallpaperPath . '/' . date('Y', $strtotime) . '/' . date('m', $strtotime) . '/' . date('d', $strtotime) . '/';
                    make_dir($_savepath);
                    $image = \think\Image::open($imgPath);
                    $image->save($_savepath . $imgName);
                    unlink($imgPath);
                }
                $v['img']      = $imgName;
                $detailsTemp[] = $v;
            }
        }
        dump($detailsTemp);
        // die;

        model('BingWallpaper')->saveAll($bingData);
        model('BingBranchBrief')->saveAll($briefTemp);
        model('BingBranchDetails')->saveAll($detailsTemp);

    }

    /**
     * { f_order 排序 }
     *
     * @param      <type>   $arr    The arr
     * @param      <type>   $field  The field
     * @param      integer  $sort   The sort 1为正序，其它为反序
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public function f_order($arr, $field, $sort)
    {
        $order = array();
        foreach ($arr as $kay => $value) {
            $order[] = $value[$field];
        }
        if ($sort == 1) {
            array_multisort($order, SORT_ASC, $arr);
        } else {
            array_multisort($order, SORT_DESC, $arr);
        }
        return $arr;
    }

    /**
     * [ getbingwallpaper 获取图片 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T13:35:23+0800
     * @return   [type]                   [加密后的类型，]
     */
    public function getbingwallpaper()
    {

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
        die;
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
        $sourcecode = $this->url_get_content('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1'); // 采集网址

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

        $picformat  = '.' . pathinfo($oldurl, PATHINFO_EXTENSION); // 图片格式
        $picformat1 = pathinfo($oldurl, PATHINFO_EXTENSION);
        $oldname    = str_replace('/az/hprichbg/rb/', '', $matchesurl[1]); // 取得图片名称

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
        // $bigImgPath = $this->save_pic($oldurlbig, $newname, $this->savePath);
        $bigImgPath = $this->saveRemoteFile($oldurlbig, $newname, $this->savePath);

        if (is_file($bigImgPath)) {
            $image = \think\Image::open($bigImgPath); // 实例化图像
            $image->thumb(640, 640)->save($this->savePath . 'thumb-' . $newname); // 缩略图本地开始
            //$image->save($savepathbig . $newnamebig, $picformat1, 90, true); // 保存 1920 X 1080
            //$image->save($savepathcnbig . $newnamecnbig, $picformat1, 90, true); // 保存 1920 X 1080 带中文
            copy($bigImgPath, $savepathbig . $newnamebig); // 使用 copy 不改变文件大小
            copy($bigImgPath, $savepathcnbig . $newnamecnbig); // 使用 copy 不改变文件大小
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

        $img1 = $this->saveRemoteFile($imgOld1, $detailsName1, $this->tempPath); // 执行临时文件保存操作
        $img2 = $this->saveRemoteFile($imgOld2, $detailsName2, $this->tempPath); // 执行临时文件保存操作

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

}
