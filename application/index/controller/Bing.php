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
use traits\controller\Jump;

class Bing {
	use Jump;

	public function index() {
		make_dir('D:/www/bingwallpaper/11');
		dump('bing');
	}

	public function getbingwallpapertest() {
		// $sourcecode = file_get_contents('http://cn.bing.com'); // 采集网址
		// dump($sourcecode);
		$data = QueryList::get('http://cn.bing.com/cnhp/life')->rules([
			'title' => ['.hplaT .hplaTtl', 'text'],
			'country' => ['.hplaT .hplaAttr', 'text'],
			'hplatt' => ['.hplaCata .hplatt', 'text'],
			'hplats' => ['.hplaCata .hplats', 'text'],
			'desc' => ['.hplaCata #hplaSnippet', 'text'],

			'scenic0_title' => ['.hplaCata .hplac:eq(0) .hplactt', 'text'],
			'scenic0_content' => ['.hplaCata .hplac:eq(0) .hplactc', 'text'],
			'scenic1_title' => ['.hplaCata .hplac:eq(1) .hplactt', 'text'],
			'scenic1_content' => ['.hplaCata .hplac:eq(1) .hplactc', 'text'],
			'scenic2_title' => ['.hplaCata .hplac:eq(2) .hplactt', 'text'],
			'scenic2_content' => ['.hplaCata .hplac:eq(2) .hplactc', 'text'],
			'scenic3_title' => ['.hplaCata .hplac:eq(3) .hplactt', 'text'],
			'scenic3_content' => ['.hplaCata .hplac:eq(3) .hplactc', 'text'],

			'scenic4_title' => ['.hplaCard:eq(0) .hplatt span', 'text'],
			'scenic4_desc' => ['.hplaCard:eq(0) .hplats', 'text'],
			'scenic4_img' => ['.hplaCard:eq(0) .rms_img', 'src'],
			'scenic4_content' => ['.hplaCard:eq(0) .hplatxt', 'text'],

			'scenic5_title' => ['.hplaCard:eq(1) .hplatt span', 'text'],
			'scenic5_desc' => ['.hplaCard:eq(1) .hplats', 'text'],
			'scenic5_img' => ['.hplaCard:eq(1) .rms_img', 'src'],
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

	public function getbingwallpaper() {
		$type = input('type');
		if (!$type) {
			$this->error('参数错误');
		}
		$wallpaperData = $this->getWallpaperData();
		// dump($wallpaperData);

		$scenicData = $this->getScenicData();
		dump($scenicData['brief']);
		dump($scenicData['details']);

		$wallpaperData = array_merge($wallpaperData, $scenicData['bing']);
		dump($wallpaperData);

		model('BingWallpaper')->save($wallpaperData);
		model('BingScenicBrief')->saveAll($scenicData['brief']);
		model('BingScenicDetails')->saveAll($scenicData['details']);

	}

	private function getWallpaperData($type = 0) {
		$sourcecode = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1'); // 采集网址

		$oldurl = '';
		$oldurlbig = '';

		if (preg_match("/<url>(.+?)<\/url>/ies", $sourcecode, $matchesurl)) {
			$oldurl = 'http://cn.bing.com' . $matchesurl[1];
			$oldurlbig = str_ireplace('1366x768', '1920x1080', $oldurl);
		}

		$oldname = str_replace("/az/hprichbg/rb/", "", $matchesurl[1]);

		//$picformat    = strstr($oldname,'.');    // 图片格式
		$picformat = '.' . pathinfo($oldurl, PATHINFO_EXTENSION); // 图片格式

		$titlelong = '';
		if (preg_match("/<copyright>(.+?)<\/copyright>/ies", $sourcecode, $matchesremark)) {
			$titlelong = $matchesremark[1]; // 图片标题（有作者）
		}

		$author = '';
		if (preg_match('/\((.+?)\)/', $titlelong, $matcheauthor)) {
			$authorArr = explode('©', $matcheauthor[1]);
			$author = trim($authorArr[1]);
		}

		$title = trim(preg_replace("/\((.*)\)/", "", $titlelong)); // 去掉小括号里的内容和前后的空格

		$description = '';
		if (preg_match_all("/<hotspot>(.+?)<\/hotspot>/ies", $sourcecode, $matcheshotspot)) {
			$hotspot = $matcheshotspot[1];
			$count = count($hotspot);

			for ($i = 0; $i < $count; $i++) {
				if (preg_match_all("/<desc>(.+?)<\/desc>/ies", $hotspot[$i], $matchesdesc)) {
					$descArr = $matchesdesc[1];
					$description .= $descArr[0];
				}
				if (preg_match_all("/<query>(.+?)<\/query>/ies", $hotspot[$i], $matchesquery)) {
					$queryArr = $matchesquery[1];
					$desc .= $queryArr[0];
				}
			}

		}

		$year = date('Y'); // 年
		$month = date('m'); // 月
		$country = 'CN'; // 国别
		$datesign = $year . $month . date('d');

		// $basepath       = '/home/wwwroot/ceroot/domain/bing/web/wallpaper/' . $year . $month . '/';
		$basepath = 'D:/www/bingwallpaper/' . $year . $month . '/';
		$savepath = $basepath; // 保存路径
		$savepathbig = $basepath . '1920X1080/'; // 保存路径
		$savepathcn = $basepath . 'cn/'; // 保存路径
		$savepathcnbig = $basepath . 'cn/1920X1080/'; // 保存路径

		$day = date('Y-m-d'); // 有年有月有日
		$filename = 'BingWallpaper-' . $day . $picformat; // 图片名称
		$filenamebig = 'BingWallpaper-1920x1080-' . $day . $picformat;
		$filenamecn = 'BingWallpaper-' . $day . '（' . $title . '）' . $picformat; // 图片名称（有中文说明）
		$filenamecnbig = 'BingWallpaper-1920x1080-' . $day . '（' . $title . '）' . $picformat;

		$newname = mb_convert_encoding($filename, "UTF-8", "auto"); // 文件名编码转换
		$newnamebig = mb_convert_encoding($filenamebig, "UTF-8", "auto"); // 文件名编码转换
		$newnamecn = mb_convert_encoding($filenamecn, "GB2312", "auto"); // 文件名编码转换
		$newnamecnbig = mb_convert_encoding($filenamecnbig, "GB2312", "auto"); // 文件名编码转换

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
			echo 'year：' . $year;
			echo '<br/><br/>';
			echo 'month：' . $month;
			echo '<br/><br/>';
			echo 'country：' . $country;
			echo '<br/><br/>';
			echo 'datesign：' . $datesign;
			echo '<br/><br/>';
			echo 'newname：' . $newname;
			echo '<br/><br/>';
			echo 'newnamebig：' . $newnamebig;
			echo '<br/><br/>';
			echo 'newnamecn：' . $newnamecn;
			echo '<br/><br/>';
			echo 'newnamecnbig：' . $newnamecnbig;
			echo '<br/><br/>';
		}

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
		$dstimg = $dstpath . 'thumb-' . $day . $picformat;

		$resize_width = 280;
		$resize_height = 165;
		$cut = 0;
		$quality = 90;

		$imgInfo = getimagesize($oldurl);
		$width = $imgInfo[0];
		$height = $imgInfo[1];
		$im = '';

		$resize_ratio = $resize_width / $resize_height; // 改变后的图象的比例
		$ratio = $width / $height; // 实际图象的比例

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

		$data['datesign'] = $datesign;
		$data['oldname'] = $oldname;
		$data['newname'] = $newname;
		$data['title'] = $title;
		$data['titlelong'] = $titlelong;
		$data['author'] = $author;
		$data['description'] = $description;
		$data['oldurl'] = $oldurl;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['country'] = $country;

		return $data;
	}

	private function getScenicData($type = 0) {
		$data = QueryList::get('http://cn.bing.com/cnhp/life')->rules([
			'hplaTtl' => ['#hplaT .hplaTtl', 'text'],
			'hplaAttr' => ['#hplaT .hplaAttr', 'text'],
			'hplatt' => ['.hplaCata .hplatt', 'text'],
			'hplats' => ['.hplaCata .hplats', 'text'],

			'description' => ['.hplaCata #hplaSnippet', 'text'],

			'brief0_title' => ['.hplaCata .hplac:eq(0) .hplactt', 'text'],
			'brief0_description' => ['.hplaCata .hplac:eq(0) .hplactc', 'text'],
			'brief1_title' => ['.hplaCata .hplac:eq(1) .hplactt', 'text'],
			'brief1_description' => ['.hplaCata .hplac:eq(1) .hplactc', 'text'],
			'brief2_title' => ['.hplaCata .hplac:eq(2) .hplactt', 'text'],
			'brief2_description' => ['.hplaCata .hplac:eq(2) .hplactc', 'text'],
			'brief3_title' => ['.hplaCata .hplac:eq(3) .hplactt', 'text'],
			'brief3_description' => ['.hplaCata .hplac:eq(3) .hplactc', 'text'],

			'details0_title' => ['.hplaCard:eq(0) .hplatt span', 'text'],
			'details0_resume' => ['.hplaCard:eq(0) .hplats', 'text'],
			'details0_img' => ['.hplaCard:eq(0) .rms_img', 'src'],
			'details0_description' => ['.hplaCard:eq(0) .hplatxt', 'text'],
			'details1_title' => ['.hplaCard:eq(1) .hplatt span', 'text'],
			'details1_resume' => ['.hplaCard:eq(1) .hplats', 'text'],
			'details1_img' => ['.hplaCard:eq(1) .rms_img', 'src'],
			'details1_description' => ['.hplaCard:eq(1) .hplatxt', 'text'],

		])->query()->getData();

		$scenic = $data->all();
		$year = date('Y'); // 年
		$month = date('m'); // 月
		$day = date('d');

		$datesign = $year . $month . $day;

		// dump($scenic);

		$bing['item_ttl'] = $scenic[0]['hplaTtl'];
		$bing['item_attr'] = $scenic[0]['hplaAttr'];
		$bing['item_tt'] = $scenic[0]['hplatt'];
		$bing['item_ts'] = $scenic[0]['hplats'];
		$bing['description'] = $scenic[0]['description'];

		$brief[0]['datesign'] = $datesign;
		$brief[0]['year'] = $year;
		$brief[0]['month'] = $month;
		$brief[0]['day'] = $day;
		$brief[0]['title'] = $scenic[0]['brief0_title'];
		$brief[0]['description'] = $scenic[0]['brief0_description'];
		$brief[1]['datesign'] = $datesign;
		$brief[1]['year'] = $year;
		$brief[1]['month'] = $month;
		$brief[1]['day'] = $day;
		$brief[1]['title'] = $scenic[0]['brief1_title'];
		$brief[1]['description'] = $scenic[0]['brief1_description'];
		$brief[2]['datesign'] = $datesign;
		$brief[2]['year'] = $year;
		$brief[2]['month'] = $month;
		$brief[2]['day'] = $day;
		$brief[2]['title'] = $scenic[0]['brief2_title'];
		$brief[2]['description'] = $scenic[0]['brief2_description'];
		$brief[3]['datesign'] = $datesign;
		$brief[3]['year'] = $year;
		$brief[3]['month'] = $month;
		$brief[3]['day'] = $day;
		$brief[3]['title'] = $scenic[0]['brief3_title'];
		$brief[3]['description'] = $scenic[0]['brief3_description'];

		$basepath = 'D:/www/bingwallpaper/' . $year . $month . '/';
		$savepath = $basepath . 'scenic/';

		$imgOld1 = $scenic[1]['details0_img'];
		$imgOld2 = $scenic[1]['details1_img'];

		$detailsName1 = md5(microtime() . $this->getSuffix($imgOld1)) . '.jpg';
		$detailsName2 = md5(microtime() . $this->getSuffix($imgOld2)) . '.jpg';

		$this->get_pic($imgOld1, $detailsName1, $savepath);
		$this->get_pic($imgOld2, $detailsName2, $savepath);

		$details[0]['datesign'] = $datesign;
		$details[0]['year'] = $year;
		$details[0]['month'] = $month;
		$details[0]['day'] = $day;
		$details[0]['title'] = $scenic[0]['details0_title'];
		$details[0]['resume'] = $scenic[0]['details0_resume'];
		$details[0]['img'] = $detailsName1;
		$details[0]['imgold'] = $scenic[1]['details0_img'];
		$details[0]['description'] = $scenic[0]['details0_description'];
		$details[1]['datesign'] = $datesign;
		$details[1]['year'] = $year;
		$details[1]['month'] = $month;
		$details[1]['day'] = $day;
		$details[1]['title'] = $scenic[0]['details1_title'];
		$details[1]['resume'] = $scenic[0]['details1_resume'];
		$details[1]['img'] = $detailsName2;
		$details[1]['imgold'] = $scenic[1]['details1_img'];
		$details[1]['description'] = $scenic[0]['details1_description'];

		$scenicData['bing'] = $bing;
		$scenicData['brief'] = $brief;
		$scenicData['details'] = $details;

		if ($type) {
			dump($scenicData);
		}
		return $scenicData;

	}

	private function get_pic($cont, $picName, $path) {
		$this->save_pic($cont, $picName, $path); //下载并保存图片
	}

	//然后将几个函数组合，在函数save_pic()中调用，最后返回保存后的图片路径。
	/*
	     * 参数:
	    @string: $url 文件远程url;
	    @string: $picName 保存文件名称;
	    @string: $savepath 文件保存路径;
*/
	private function save_pic($url, $picName, $savepath = '') {
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
	private function read_filetext($filepath) {

		$filepath = trim($filepath);
		$htmlfp = @fopen($filepath, "r");
		$string = '';

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
	private function write_filetext($filepath, $string) {
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
	private function get_filename($filepath) {
		$fr = explode("/", $filepath);
		$count = count($fr) - 1;
		return $fr[$count];
	}

	//函数getSuffix()获取文件后缀名
	/*
	     * 参数:
	    @string: $filepath 文件路径;
*/
	private function getSuffix($filepath) {
		$fr = explode("/", $filepath);
		$count = count($fr) - 1;
		$fr = $fr[$count];
		$fr = explode(".", $fr);
		$count = count($fr) - 1;
		return end($fr);
	}

	//函数picInfo()获取文件信息
	/*
	     * 参数:
	    @string: $filepath 文件路径;
*/
	private function picInfo($filepath) {
		if (!$filepath == '') {
			$fileName1 = realpath($filepath);
			$size = getimagesize($fileName1);
			print_r($size);
		}
	}

	public function hello($name = 'ThinkPHP5') {
		return 'hello,' . $name;
	}
}
