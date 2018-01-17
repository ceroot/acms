<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
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

use app\facade\Tools;
use app\index\controller\Base;
use Qcloud_cos\Auth;
use Qcloud_cos\Cosapi;
use QL\QueryList;
use traits\controller\Jump;

class Bing extends Base
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
    //http://www.istartedsomething.com/bingimages/

    protected $qcloudCosPath;
    protected $qCloudBucketName;

    /**
     * [initialize 控制器初始化]
     */
    public function initialize()
    {
        parent::initialize();

        $this->year     = date('Y');
        $this->month    = date('m');
        $this->day      = date('d');
        $this->datesign = $this->year . $this->month . $this->day; // 日期标记赋值

        $this->bingwallpaperPath = './data/bingwallpaper/'; // bing 目录
        $this->tempPath          = $this->bingwallpaperPath . 'temp/'; // 临时目录赋值
        $this->basePath          = $this->bingwallpaperPath . $this->year . '/' . $this->month . '/'; // 基本目录赋值
        $this->savePath          = $this->basePath . $this->day . '/'; // 保存目录赋值

        make_dir($this->basePath); // 创建保存目录
        make_dir($this->savePath); // 创建保存目录

        $this->qcloudCosPath    = '/' . $this->year . '/' . $this->month . '/' . $this->day;
        $this->qCloudBucketName = 'bing';

        $imgbaseurl = Tools::isLocal() ? '/data/bingwallpaper/' : 'https://bing-10015504.file.myqcloud.com/';
        $this->assign('imgbaseurl', $imgbaseurl);

        Tools::test();

    }

    public function test()
    {

        return view();

    }

    // 腾讯对象存储函数
    /*
     * 参数:
    @string: $bucketName  bucket 名称
    @string: $path 目录地址;
    @string: $srcPath  源文件地址
    @string: $filename 文件名称;
     */
    public function qcloud_cos($bucketName, $path, $srcPath, $filename)
    {
        if (Tools::isLocal(request()->ip())) {
            return false;
        }

        // statFolder
        $statRet = Cosapi::statFolder($bucketName, $path);

        //var_dump($statRet);
        // 判断目录是否存在，不正在进行创建
        if ($statRet['code'] != 0) {
            //创建目录
            $createFolderRet = Cosapi::createFolder($bucketName, $path);
            //var_dump($createFolderRet);
        }
        // dump($statRet);die;
        //上传文件
        // $srcPath  = '/home/wwwroot/ceroot/domain/bing/web/201602230102.jpg';
        $dstPath = $path . '/' . $filename;

        $uploadRet = Cosapi::upload($srcPath, $bucketName, $dstPath);
        //dump($uploadRet);
        //return $uploadRet;
    }

    public function index($limit = 15)
    {
        // debug('begin');
        if (request()->isMobile()) {
            $limit = 30;
        }
        // dump('bing');
        $data = model('BingWallpaper')->order('datesign', 'desc')->paginate($limit, '', [
            'type'     => '\page\Bootstrap',
            'var_page' => 'page',
        ]);
        // $data = model('BingWallpaper')->order('datesign', 'desc')->paginate($limit);
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
        // debug('end');
        // dump(debug('begin', 'end'));
        return $this->fetch();
    }

    public function details($id)
    {
        // dump('details');
        $id || $this->error('参数错误');
        $id = deauthcode($id);
        $id || $this->error('参数值错误');

        // dump($id);die;
        $model = model('BingWallpaper');
        $model->where('id', $id)->setInc('viewcount');

        $data = $model->get($id);
        $data || $this->error('数据不存在');

        $datesign = $data['datesign'];

        $data['brief']   = model('BingBranchBrief')->where('datesign', $datesign)->select();
        $data['first']   = model('BingBranchDetails')->where([['datesign', '=', $datesign], ['type', '=', 1]])->find();
        $data['details'] = model('BingBranchDetails')->where([['datesign', '=', $datesign], ['type', '=', 0]])->select();

        $groom       = '';
        $description = $data['description'] ?: $data['title'];
        // dump($description);
        if ($description) {
            $keywords    = get_keywords($description, 5);
            $keywordsArr = explode(',', $keywords);

            $whereLike = [];
            foreach ($keywordsArr as $key => $value) {
                $value       = '%' . $value . '%';
                $whereLike[] = $value;
            }

            $where = [
                ['id', '<>', $data['id']],
            ];

            $limit = 8;
            if (request()->isMobile()) {
                $limit = 12;
            }
            $groom = $model->where($where)->where('title', 'like', $whereLike, 'OR')->order('id', 'desc')->limit($limit)->select();

        }

        $prevId = $this->getPrevNextId($id);
        $nextId = $this->getPrevNextId($id, 1);
        // $data['previd'] = is_numeric($prevId) ? authcode($prevId) : $prevId;
        // $data['nextid'] = is_numeric($nextId) ? authcode($nextId) : $nextId;
        $data['previd']   = $prevId;
        $data['nextid']   = $nextId;
        $data['keywords'] = $keywords;

        $wxdata['timestamp'] = time();
        $wxdata['nonce']     = md5(time());
        $wxdata['signature'] = md5(md5(time()));

        // dump($data);
        // die;
        $this->assign('groom', $groom);
        $this->assign('data', $data);
        $this->assign('wxdata', $wxdata);
        return $this->fetch();

    }
    /**
     * [ getPrevNextId 根据 id 取得上一项下一项的 id ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-29T17:56:04+0800
     * @param    [type]                   $id   [description]
     * @param    integer                  $type [description]
     * @return   [type]                         [description]
     */
    private function getPrevNextId($id, $type = 0)
    {
        $model  = model('BingWallpaper');
        $tempId = $id;
        if ($type) {
            $id     = $id + 1;
            $tipsId = $model->max('id');
            $tips   = '未来在路上，请稍等……';
        } else {
            $id     = $id - 1;
            $tipsId = $model->min('id');
            $tips   = '已经是第一个了';
        }

        if ($tempId == $tipsId) {
            return $tips;
        }

        $data = $model->get($id);
        if (!$data) {
            return $this->getPrevNextId($id, $type);
        } else {
            return $id;
        }
    }

    public function download($id, $i, $w)
    {
        // is_numeric($w) || $this->error('参数错误');
        $id = deauthcode($id);
        $id || $this->error('参数错误');
        $file = deauthcode($i);
        $file || $this->error('参数错误');

        is_file($file) || $this->error('文件不存在');

        $fileName = basename($file);
        $model    = model('BingWallpaper');

        if ($w == '1920x1080') {
            $fileName = str_replace('.jpg', '_' . $w . '.jpg', $fileName);
            header("Content-type: application/octet-stream");
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header("Content-Length: " . filesize($file));
            readfile($file);
        } else {

            if ($w == '1440x900') {
                $wValue = '1440';
            } elseif ($w == '1366x768') {
                $wValue = '1366';
            } elseif ($w == '1024x768') {
                $wValue = '1024';
            } else {
                return 'error';
            }

            ob_start();
            $this->imgResize($file, $wValue);
            $s = ob_get_clean();

            $fileName = str_replace('.jpg', '_' . $w . '.jpg', $fileName);
            header("Content-Type: image/jpeg");
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . strlen($s));
            echo $s;
        }

        $model->where('id', $id)->setInc('downcount');
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
        // getbingwallpaper?type=b1a1xcodQ6629k8qRuFBowJn0eXRjcyCaZc2JaSdCC5GYi54
        //b1a1xcodQ6629k8qRuFBowJn0eXRjcyCaZc2JaSdCC5GYi54//
        //dump(authcode('getBing'));

        // 判断参数
        $type || $this->error('参数错误');

        (deauthcode($type) == 'getBing') || $this->error('参数值错误');

        // 获取 bing 图片数据
        $wallpaperData = $this->getWallpaperData();
        // dump($wallpaperData);

        // 验证数据
        // $validate = validate('BingWallpaper');
        // if (!$validate->check($wallpaperData)) {
        //     return $this->error($validate->getError());
        // }

        // 获取景区数据
        $branchData = $this->getBranchData();

        // 数据组合
        $wallpaperData = array_merge($wallpaperData, $branchData['bing']);

        //dump($wallpaperData);
        //dump($branchData['brief']);
        //dump($branchData['details']);

        // 数据写入
        $status = model('BingWallpaper')->save($wallpaperData);
        if ($status) {
            model('BingBranchBrief')->saveAll($branchData['brief']);
            model('BingBranchDetails')->saveAll($branchData['details']);
        } else {
            $log     = data('Y-m-d H:i:s');
            $logFile = $this->bingwallpaperPath . 'log/' . date('Ymd', strtotime($this->datesign)) . '.log'; // 记录日志文件地址
            file_put_contents($logFile, $log, FILE_APPEND);
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
        $sourcecode = url_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1'); // 采集网址

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

        $filename   = trim(str_replace('_1366x768', '', $oldname)); // 去掉名称中有 _1366x768
        $newname    = mb_convert_encoding($filename, 'UTF-8', 'auto'); // 文件名编码转换
        $newnamebig = mb_convert_encoding($filenamebig, 'UTF-8', 'auto'); // 文件名编码转换
        // $newnamecnbig = mb_convert_encoding($filenamecnbig, 'GB2312', 'auto'); // 文件名编码转换
        $newnamecnbig = mb_convert_encoding($filenamecnbig, 'UTF-8', 'auto'); // 文件名编码转换

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
        $bigImgPath = Tools::saveRemoteFile($oldurlbig, $newname, $this->savePath);

        if (is_file($bigImgPath)) {
            $thumb = 'thumb_' . $newname;
            $image = \think\Image::open($bigImgPath); // 实例化图像
            $image->thumb(640, 640)->save($this->savePath . $thumb); // 缩略图本地开始
            //$image->save($savepathbig . $newnamebig, $picformat1, 90, true); // 保存 1920 X 1080
            //$image->save($savepathcnbig . $newnamecnbig, $picformat1, 90, true); // 保存 1920 X 1080 带中文
            copy($bigImgPath, $savepathbig . $newnamebig); // 使用 copy 不改变文件大小
            copy($bigImgPath, $savepathcnbig . $newnamecnbig); // 使用 copy 不改变文件大小

            // 腾讯对象存储
            $this->qcloud_cos($this->qCloudBucketName, $this->qcloudCosPath, $bigImgPath, $newname);
            $thumbPath = $this->savePath . $thumb;
            if (is_file($thumbPath)) {
                $this->qcloud_cos($this->qCloudBucketName, $this->qcloudCosPath, $thumbPath, $thumb);
            }

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
        $data['source']      = '';

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
            'rms_img'              => ['#hplaDL img.rms_img', 'src'],
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
        // dump($scenic);die;

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

        $img1 = Tools::saveRemoteFile($imgOld1, $detailsName1, $this->tempPath); // 执行临时文件保存操作
        $img2 = Tools::saveRemoteFile($imgOld2, $detailsName2, $this->tempPath); // 执行临时文件保存操作

        // 图片1迁移
        if (is_file($img1)) {
            $image = \think\Image::open($img1);
            $image->save($this->savePath . $detailsName1);

            // 腾讯对象存储
            $imgLocalPath = $this->savePath . $detailsName1;
            $this->qcloud_cos($this->qCloudBucketName, $this->qcloudCosPath, $imgLocalPath, $detailsName1);

            unlink($img1); // 删除临时文件
        }

        // 图片2迁移
        if (is_file($img2)) {
            $image = \think\Image::open($img2);
            $image->save($this->savePath . $detailsName2);

            // 腾讯对象存储
            $imgLocalPath = $this->savePath . $detailsName2;
            $this->qcloud_cos($this->qCloudBucketName, $this->qcloudCosPath, $imgLocalPath, $detailsName2);

            unlink($img2); // 删除临时文件
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

        // 组合移动端的另一项
        $mobileData = $this->getBranchDataFirst();
        // dump($details);die;
        // 数据组合
        $reData['bing']    = $bing;
        $reData['brief']   = $brief;
        $reData['details'] = $details;
        $reData['details'] = array_merge($mobileData, $details);
        // dump($reData);die;
        if ($type) {
            dump($reData);
        }
        return $reData;
    }

    /**
     * [ getBranchDataFirst 获得移动端显示的第一张的数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-15T15:19:51+0800
     * @return   [type]                         [description]
     */
    public function getBranchDataFirst()
    {
        // 使用 QueryList 取得数据
        $data = QueryList::get('http://cn.bing.com/cnhp/life', [], [
            'headers' => [
                'Referer'    => 'https://querylist.cc/',
                'User-Agent' => 'iPhone/1.0',
                'Accept'     => 'application/json',
                'X-Foo'      => ['Bar', 'Baz'],
                //'Cookie'     => 'abc=111;xxx=222',
            ],
        ])->rules([
            'hplatt'  => ['.hplaDft .hplatBlue .hplatt', 'text'],
            'hplats'  => ['.hplaDft .hplatBlue .hplats', 'text'],
            'hplatxt' => ['.hplaDft:eq(1) .hplatxt:eq(0)', 'text'],
            'rms_img' => ['.hplaDft:eq(1) .rms_img', 'src'],
        ])->query()->getData();

        $scenic  = $data->all(); // 取得数据
        $details = [];
        if ($scenic) {
            $imgOld      = $scenic[0]['rms_img']; // 取得图片 url
            $detailsName = md5(microtime() . $imgOld) . '.jpg'; // 图片名称带后缀
            $imgTemp     = Tools::saveRemoteFile($imgOld, $detailsName, $this->tempPath); // 执行临时文件保存操作
            $imgPath     = $this->savePath . $detailsName;

            // 图片1迁移
            if (is_file($imgTemp)) {
                $image = \think\Image::open($imgTemp);
                $image->save($imgPath);
                unlink($imgTemp); // 删除临时文件

                // 腾讯对象存储
                if (is_file($imgPath)) {
                    $this->qcloud_cos($this->qCloudBucketName, $this->qcloudCosPath, $imgPath, $detailsName);
                }
            }

            $details[3]['datesign']    = $this->datesign;
            $details[3]['title']       = $scenic[0]['hplatt'];
            $details[3]['resume']      = $scenic[0]['hplats'];
            $details[3]['img']         = $detailsName;
            $details[3]['imgold']      = $scenic[0]['rms_img'];
            $details[3]['description'] = $scenic[0]['hplatxt'];
            $details[3]['type']        = 1;
        }

        return $details;
    }

    public function nametocn($f)
    {
        $f        = $f . '01';
        $date     = date($f);
        $firstday = date('Ym01', strtotime($date));
        $lastday  = date('Ymd', strtotime("$firstday +1 month -1 day"));

        $where = [
            ['datesign', '>=', $firstday],
            ['datesign', '<=', $lastday],
        ];
        $data = db('BingWallpaper')->where($where)->select();

        foreach ($data as $value) {
            $title     = $value['title'];
            $datesign  = $value['datesign'];
            $strtotime = strtotime($datesign);
            $newname   = $value['newname'];
            $newnamecn = 'BingWallpaper-1920x1080-' . date('Y-m-d', $strtotime) . '（' . $title . '）.jpg';

            $_basePath = $this->bingwallpaperPath . date('Y/m/d/', $strtotime);
            // dump($this->bingwallpaperPath . date('Y/m/', $strtotime) . '/1920X1080_cn/');die;
            if (is_file($_basePath . $newname)) {
                copy($_basePath . $newname, $this->bingwallpaperPath . date('Y/m/', $strtotime) . '/1920X1080_cn/' . $newnamecn);
            } else {
                dump($_basePath . $newname);
            }
        }
    }

}
