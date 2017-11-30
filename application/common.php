<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//

use app\facade\Tools;
use app\facade\User;
use think\facade\Env;
use think\facade\Request;

/**
 * [ip2int ip地址转换为int]
 * @param   string  $ip  [ip地址]
 * @return  int          [返回整形数字]
 * @author  SpringYang <ceroot@163.com>
 */
if (!function_exists('ip2int')) {
    function ip2int($ip = '')
    {
        if ($ip == '') {
            $ip = Request::ip();
        }
        return sprintf("%u", ip2long($ip));
    }
}

/**
 * 将驼峰式命名转换为下划线命名
 * @param  string $str [字符串]
 * @return string      [返回字符]
 * @author SpringYang <ceroot@163.com>
 */
function toUnderline($str)
{
    $temp_array = array();
    for ($i = 0; $i < strlen($str); $i++) {
        $ascii_code = ord($str[$i]);
        if ($ascii_code >= 65 && $ascii_code <= 90) {
            if ($i == 0) {
                $temp_array[] = chr($ascii_code + 32);
            } else {
                $temp_array[] = '_' . chr($ascii_code + 32);
            }
        } else {
            $temp_array[] = $str[$i];
        }
    }
    return implode('', $temp_array);
}

/**
 * 将下划线命名转换为驼峰式命名
 * @param  string $str [字符串]
 * @return string      [返回字符]
 * @author SpringYang <ceroot@163.com>
 */
function toCamel($str)
{
    $str = ucwords(str_replace('_', ' ', $str));
    $str = str_replace(' ', '', lcfirst($str));
    return $str;
}

/**
 * authcode 这是一个加密的东西
 * @param str string    // 字符串
 * @param type string   // 类型
 */
if (!function_exists('authcode')) {
    function authcode($str, $type = '')
    {
        // $authcode = new \authcode\Authcode();

        $code    = '';
        $restr_a = '+'; // 加密后有加号
        $tostr_a = '-'; // 使用减号替换加号
        $restr_b = '/'; // 加密后有斜扛
        $tostr_b = '^'; // 使用^替换斜扛

        if ($type === '') {
            $type = 'CODE';
            // $code  = $authcode->authcode($str, $type);
            $code  = Tools::authCode($str, $type);
            $pos_a = strpos($code, $restr_a);
            $pos_b = strpos($code, $restr_b);
            if ($pos_a) {
                $code = str_replace($restr_a, $tostr_a, $code);
            }

            if ($pos_b) {
                $code = str_replace($restr_b, $tostr_b, $code);
            }

        } else {
            $pos_a = strpos($str, $tostr_a);
            $pos_b = strpos($str, $tostr_b);
            if ($pos_a) {
                $str = str_replace($tostr_a, $restr_a, $str);
            }

            if ($pos_b) {
                $str = str_replace($tostr_b, $restr_b, $str);
            }

            // $code = $authcode->authcode($str, $type);
            $code = Tools::authCode($str, $type);
        }
        return $code;
    }
}

/**
 * deauthcode  解密 authcode 进行加密的字符串
 * @param str string    // 字符串
 */
if (!function_exists('deauthcode')) {
    function deauthcode($str)
    {
        return authcode($str, 'DECODE');
    }
}

/**
 * 退出 url
 * @return     string  [url地址]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('logouturl')) {
    function logouturl()
    {
        // $loginout = url('Login/loginout') . '?backurl=' . getbackurl();
        $loginout = url('console/start/logout?time=' . date('YmdHis') . getrandom(128)) . '?backurl=' . getbackurl();
        return $loginout;
    }
}

/**
 * getcurrenturl  取得当前url并转换成asc
 * 退出 url
 * @param  boolean     $suffix  [是否带后缀，默认还后缀]
 * @return string               [url地址]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('getbackurl')) {
    function getbackurl($suffix = true)
    {
        if ($suffix) {
            $backurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $backurl = request()->domain() . '/' . request()->path();
        }
        $backurl = rawurlencode($backurl);
        return $backurl;
    }
}

/**
 * time_format 时间戳格式化
 * @param  int     $time   [时间]
 * @param  string  $format [时间格式]
 * @return string          [返回时间显示格式]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('time_format')) {
    function time_format($time = null, $format = 'Y-m-d H:i:s')
    {
        if (empty($time)) {
            $time = time();
        }
        return date($format, intval($time));
    }
}

/**
 * 格式化字节大小
 * @param  number $size 字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '')
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= 1024 && $i < 5; $i++) {
        $size /= 1024;
    }
    return $size . $delimiter . $units[$i];
}

// 函数make_dir()建立目录。判断要保存的图片文件目录是否存在，如果不存在则创建目录，并且将目录设置为可写权限。
/*
 * 参数:
@string: $path 目录路径;
 */
function make_dir($path)
{
    if (!file_exists($path)) {
        // 如果文件夹不存在则建立
        make_dir(dirname($path)); // 多层创建
        mkdir($path, 0755); // 给文件夹设置权
        @chmod($path, 0755);
    }
    return true;
}

/**
 * 取得管理员昵称
 * @param  int    $uid  [用户id]
 * @return string       [返回字符]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('get_username')) {
    function get_username($uid = null)
    {
        return User::getUserInfo($uid, 'username');
    }
}

/**
 * 取得管理员昵称
 * @param  int    $uid  [用户id]
 * @return string       [返回字符]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('get_nickname')) {
    function get_nickname($uid = null)
    {
        return User::getUserInfo($uid, 'nickname');
    }
}

/**
 * 取得管理员真实姓名
 * @param  int    $uid  [用户id]
 * @return string       [返回字符]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('get_realname')) {
    function get_realname($uid = null)
    {
        return User::getUserInfo($uid, 'realname');
    }
}

/**
 * 获得禁用和启用状态文字
 * @param  string  $table_id [表名和当前id]
 * @return string            [返回启用或者禁用]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('status_text')) {
    function status_text($table_id)
    {
        $arr   = explode('|', $table_id);
        $value = db($arr[0])->getFieldById($arr[1], 'status');
        return ($value == 1) ? '启用' : '禁用';
    }
}

/**
 * 随机数函数
 * @param  string    $length     [长度]
 * @param  int       $numeric    [类型 0为数字，1为全部，2为大小写，3为数字加大写，4为数字加小写，5为大写，6为小写，7为uniqid()]
 * @return string    $hash       [返回数字]
 * @author SpringYang <ceroot@163.com>
 */
if (!function_exists('getrandom')) {
    function getrandom($length = 6, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' && mt_srand((double) microtime() * 1000000);
        if ($length > 10 && $numeric == 0) {
            $numeric = 1;
        }

        $hash = '';
        switch ($numeric) {
            case 0:
                $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
                break;
            case 1:
                $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
                break;
            case 2:
                $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
                break;
            case 3:
                $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
                break;
            case 4:
                $chars = '23456789abcdefghjkmnpqrstuvwxyz';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
            case 5:
                $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
                break;
            case 6:
                $chars = 'abcdefghjkmnpqrstuvwxyz';
                $max   = strlen($chars) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $hash .= $chars[mt_rand(0, $max)];
                }
                break;
            case 7:
                $uniqid = implode(null, array_map('ord', str_split(md5(uniqid()), 1)));
                $max    = strlen($uniqid) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $temp = $uniqid[mt_rand(0, $max)];
                    // 去掉第一个为 0 的情况
                    if ($i == 0 && $temp == 0) {
                        $temp = sprintf('%0' . 1 . 'd', mt_rand(0, pow(10, 1) - 1));
                    }
                    $hash .= $temp;
                }
                break;
            default:
                $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
                // 代码
        }
        return $hash;
    }
}

/**
 * 生成树形结构数组
 * @param  array   $cate  传入数组
 * @param  string  $pid   传入父id
 * @return array   $arr   返回数组
 */
function getCateTreeArr($cate, $pid)
{
    $arr = [];
    foreach ($cate as $k => $v) {
        if ($v['pid'] == $pid) {
            $child = getCateTreeArr($cate, $v['id']);
            if ($child) {
                $v['items'] = $child;
            }
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * 传递一个子级返回父级id 例如:首页>>服装>>女装>>裙子
 * @param array   $cate  传入数组
 * @param string  $pid   传入id
 * @return array  $arr   返回数组
 */
function getParents($cate, $id)
{
    $arr = [];
    foreach ($cate as $v) {
        if ($v['id'] == $id) {
            $arr[] = $v;
            $arr   = array_merge(getParents($cate, $v['pid']), $arr);
        }
    }
    return $arr;
}
/**
 * 传递一个父级ID返回所有子级分类
 * @param array     $cate   传入数组
 * @param string    $pid    传入id
 * @return array    $arr    返回数组
 */
function getChiIds($cate, $pid, $str = 0)
{
    $arr           = array();
    static $strarr = array();
    foreach ($cate as $v) {
        if ($v['pid'] == $pid) {
            $arr[]    = $v;
            $strarr[] = $v['id'];
            $arr      = array_merge($arr, getChiIds($cate, $v['id']));
        }
    }
    return $str == 1 ? $strarr : $arr;
}
/**
 * 传递一个子级返回父级id 例如:首页>>服装>>女装>>裙子
 * @param array     $cate   传入数组
 * @param string    $pid    传入id
 * @return array    $arr    返回数组
 */
function getCateByPid($cate, $pid = 0)
{
    $arr = array();
    foreach ($cate as $v) {
        if ($v['pid'] == $pid) {
            // $arr[] = array('id'=>$v['id'],'name'=>$v['name']);
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * { getBroswer 获取客户端浏览器信息}
 * @Author   SpringYang
 * @DateTime 2017-10-23T11:55:15+0800
 * @return   [string]                   [description]
 */
if (!function_exists('get_broswer')) {
    function get_broswer()
    {
        $sys = $_SERVER['HTTP_USER_AGENT']; //获取用户代理字符串
        if (stripos($sys, "Firefox/") > 0) {
            preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Firefox";
            $exp[1] = $b[1]; //获取火狐浏览器的版本号
        } elseif (stripos($sys, "Maxthon") > 0) {
            preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
            $exp[0] = "傲游";
            $exp[1] = $aoyou[1];
        } elseif (stripos($sys, "MSIE") > 0) {
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "IE";
            $exp[1] = $ie[1]; //获取IE的版本号
        } elseif (stripos($sys, "OPR") > 0) {
            preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
            $exp[0] = "Opera";
            $exp[1] = $opera[1];
        } elseif (stripos($sys, "Edge") > 0) {
            //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
            preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
            $exp[0] = "Edge";
            $exp[1] = $Edge[1];
        } elseif (stripos($sys, "Chrome") > 0) {
            preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
            $exp[0] = "Chrome";
            $exp[1] = $google[1]; //获取google chrome的版本号
        } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
            preg_match("/rv:([\d\.]+)/", $sys, $IE);
            $exp[0] = "IE";
            $exp[1] = $IE[1];
        } elseif (stripos($sys, 'Safari') > 0) {
            preg_match("/safari\/([^\s]+)/i", $sys, $safari);
            $exp[0] = "Safari";
            $exp[1] = $safari[1];
        } else {
            $exp[0] = "未知浏览器";
            $exp[1] = "0.00";
        }
        return $exp[0] . '(' . $exp[1] . ')';
    }
}

/**
 * {getOs 获取客户端操作系统信息包括win10}
 * @Author   SpringYang
 * @DateTime 2017-10-23T11:54:39+0800
 * @return   [string]                   [description]
 */
if (!function_exists('get_os')) {
    function get_os()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
            $os = 'Windows 95';
        } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
            $os = 'Windows ME';
        } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
            $os = 'Windows 98';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
            $os = 'Windows 8';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
            $os = 'Windows 10'; #添加win10判断
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
            $os = 'Windows 2000';
        } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
            $os = 'Windows NT';
        } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
            $os = 'Windows 32';
        } else if (preg_match('/linux/i', $agent)) {
            $os = 'Linux';
        } else if (preg_match('/unix/i', $agent)) {
            $os = 'Unix';
        } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'SunOS';
        } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'IBM OS/2';
        } else if (preg_match('/Mac/i', $agent)) {
            $os = 'Mac';
        } else if (preg_match('/PowerPC/i', $agent)) {
            $os = 'PowerPC';
        } else if (preg_match('/AIX/i', $agent)) {
            $os = 'AIX';
        } else if (preg_match('/HPUX/i', $agent)) {
            $os = 'HPUX';
        } else if (preg_match('/NetBSD/i', $agent)) {
            $os = 'NetBSD';
        } else if (preg_match('/BSD/i', $agent)) {
            $os = 'BSD';
        } else if (preg_match('/OSF1/i', $agent)) {
            $os = 'OSF1';
        } else if (preg_match('/IRIX/i', $agent)) {
            $os = 'IRIX';
        } else if (preg_match('/FreeBSD/i', $agent)) {
            $os = 'FreeBSD';
        } else if (preg_match('/teleport/i', $agent)) {
            $os = 'teleport';
        } else if (preg_match('/flashget/i', $agent)) {
            $os = 'flashget';
        } else if (preg_match('/webzip/i', $agent)) {
            $os = 'webzip';
        } else if (preg_match('/offline/i', $agent)) {
            $os = 'offline';
        } elseif (preg_match('/ucweb|MQQBrowser|J2ME|IUC|3GW100|LG-MMS|i60|Motorola|MAUI|m9|ME860|maui|C8500|gt|k-touch|X8|htc|GT-S5660|UNTRUSTED|SCH|tianyu|lenovo|SAMSUNG/i', $agent)) {
            $os = 'mobile';
        } else {
            $os = '未知操作系统';
        }
        return $os;
    }
}

if (!function_exists('get_visit_source')) {
    function get_visit_source()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($user_agent, 'MicroMessenger') !== false) {
            return 'weixin';
        }
        $mobile_agents = array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
        $is_mobile     = false;
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
        if ($is_mobile) {
            return 'mobile';
        }

        return 'pc';
    }
}

/**
 * 处理 ueditor 富文本编辑器对图片和文件及其它的处理
 * @param  string    $content    [表单提交过来的内容]
 * @param  string    $title      [标题内容，用于图片的 alt 和 title 属性值，默认为 null，不执行]
 * @return string    $content    [返回新的内容]
 * @author SpringYang <ceroot@163.com>
 */
function ueditor_handle($content, $title = null)
{
    $pathFiles  = './data/files/'; // 文件保存路径
    $pathImages = './data/images/'; // 图片保存路径
    $pathVideos = './data/videos/'; // 视频保存路径

    // 图片替换处理
    // $patternImg = '<img.*?src="(.*?)">';
    $patternImg = '/<img.*?src="(.*?)".*?>/is';
    if (preg_match_all($patternImg, $content, $matchesImg)) {
        foreach ($matchesImg[0] as $key => $value) {
            $oldValue = $newValue = $value; // 临时变量
            if (stripos($value, 'data/ueditor') !== false) {
                $imageSrc   = $matchesImg[1][$key]; // 取得 img 里的 src
                $imagesArr  = explode('/', $imageSrc); // 以 / 拆分 src 变为数组
                $imagesName = end($imagesArr); // 取得数组里的最后一个值，也就是文件名
                $datePath   = array_slice($imagesArr, -2, 1); // 取得数组里的倒数第二个值，也就是以日期命名的目录
                $newPath    = $pathImages . $datePath[0] . '/'; // 新的文件目录

                // 判断目录是否存在，如果不存在则创建
                if (!is_dir($newPath)) {
                    make_dir($newPath);
                }

                // 文件移动
                $newPath  = $newPath . $imagesName; // 新路径
                $imageSrc = '.' . $imageSrc; // 旧路径
                if (is_file($imageSrc)) {
                    // 取得文件信息
                    $imageInfo = getimagesize($imageSrc);
                    if ($imageInfo) {
                        if ($imageInfo[0] > 800) {
                            // 实例化图片尺寸类
                            $newimage = new \imageresize\ImageResize();
                            $result   = $newimage->resize($imageSrc, $newPath, 800, 500);
                            if ($result) {
                                unlink($imageSrc); // 删除临时文件
                            }
                        } else {
                            rename($imageSrc, $newPath);
                        }
                    }
                }

            }

            if (stripos($value, 'data/') !== false) {
                // 如果标题存在的时候进行操作
                if (!empty($title)) {
                    // alt 替换
                    $patternAlt = '/<img.*alt\=[\"|\'](.*)[\"|\'].*>/i'; // alt 规则
                    $newAlt     = 'alt="' . $title . '"'; // 新的 alt

                    $altPreg = preg_match($patternAlt, $oldValue, $matchAlt);
                    if ($altPreg) {
                        $newValue = preg_replace('/alt=.+?[*|\"]/i', $newAlt, $newValue);
                    } else {
                        $valueTemp = str_replace('/>', '', $newValue);
                        $newValue  = $valueTemp . ' ' . $newAlt . '/>';
                    }

                    // 标题替换处理
                    $patternTitle = '/<img.*title\=[\"|\'](.*)[\"|\'].*>/i'; // title 规则
                    $newTitle     = 'title="' . $title . '"'; // 新的 title

                    $titlePreg = preg_match($patternTitle, $oldValue, $matchTitle);
                    if ($titlePreg) {
                        $newValue = preg_replace('/title=.+?[*|\"]/i', $newTitle, $newValue);
                    } else {
                        $valueTemp = str_replace('/>', '', $newValue);
                        $newValue  = $valueTemp . ' ' . $newTitle . '/>';
                    }
                }

                // 样式为空替换处理
                $stylePattern = '<img.*?style="(.*?)">'; // style 规则
                $stylePreg    = preg_match($stylePattern, $oldValue, $styleMatch);
                if ($stylePreg) {
                    if (empty($styleMatch[1])) {
                        $newValue = preg_replace('/style=.+?[*|\"]/i', '', $newValue);
                    }
                }

                // 替换成新的图片路径
                $newValue = str_replace('ueditor/', '', $newValue);

                // 内容替换成新的值
                $content = str_replace($oldValue, $newValue, $content);
            }
        }
    }

    // 文件替换处理
    if (preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx", $content, $links)) {
        while (list($key, $val) = each($links[2])) {
            if (!empty($val)) {
                $match['link'][] = $val;
            }
        }
        while (list($key, $val) = each($links[3])) {
            if (!empty($val)) {
                $match['link'][] = $val;
            }
        }
        while (list($key, $val) = each($links[4])) {
            if (!empty($val)) {
                $match['content'][] = $val;
            }
        }
        while (list($key, $val) = each($links[0])) {
            if (!empty($val)) {
                $match['all'][] = $val;
            }

        }

        // 文件地址处理
        foreach ($match['link'] as $value) {
            if (stripos($value, 'data/ueditor') !== false) {
                $oldValue = $value;
                $linkArr  = explode('/', $value);
                $datePath = array_slice($linkArr, -2, 1);
                $fileName = end($linkArr);
                $newPath  = $pathFiles . $datePath[0] . '/';

                // 判断目录是否存在，如果不存在则创建
                if (!is_dir($newPath)) {
                    make_dir($newPath);
                }

                // 移动文件
                $newPath = $newPath . $fileName; // 新路径
                $value   = '.' . $value; // 旧路径
                if (is_file($value)) {
                    rename($value, $newPath);
                }

                // 替换成新的文件路径
                $newvalue = str_replace('ueditor/', '', $oldValue);

                // 内容替换成新的值
                $content = str_replace($oldValue, $newvalue, $content);
            }
        }
    }

    // 附件小图标处理
    if (stripos($content, 'ueditor/1.4.3.2/dialogs/attachment') !== false) {
        $content = str_replace('ueditor/1.4.3.2/dialogs/attachment', 'images', $content);
    }
    return $content;
}

/**
 * 修改文章时删除原来数据库里被修改去的图片或者文件
 * @param  string    $dataForm    [表单提交过来的数据]
 * @param  string    $dataSql     [数据库里的数据]
 * @return string
 * @author SpringYang <ceroot@163.com>
 */
function del_file($dataForm, $dataSql)
{
    // 定义变量
    $differ = [];
    // 取得图片正则
    $patternImage = '<img.*?src="(.*?)">';
    // 匹配表单数据并取得数据
    if (preg_match_all($patternImage, $dataForm, $matchesImageForm)) {
        $imgForm = $matchesImageForm[1];
        foreach ($imgForm as $key => $value) {
            // 去除静态资源里的图片
            if (stripos($value, 'statics/')) {
                unset($imgForm[$key]);
            }
        }
    }

    // 匹配数据库数据并取得数据
    if (preg_match_all($patternImage, $dataSql, $matchesImageSql)) {
        $imgSql = $matchesImageSql[1];
        foreach ($imgSql as $key => $value) {
            // 去除静态资源里的图片
            if (stripos($value, 'statics/')) {
                unset($imgSql[$key]);
            }
        }
    }

    // 如果表单数据不为空的话就去和数据库作对比并删除不需要进行删除的数据;
    if (!empty($imgForm) && !empty($imgSql)) {
        if (is_array($imgForm) && is_array($imgSql)) {
            $imgIntersect = array_intersect($imgForm, $imgSql); // 取得交集
            $imgDiffer    = array_diff($imgSql, $imgIntersect); // 取得差集
            $differ       = array_merge($differ, $imgDiffer); // 合并数组并统一赋值给 $differ
        }
    }

    // 取得a标签正则
    $patternHref = '<a.*?href="(.*?)">';
    // 匹配表单数据并取得数据
    if (preg_match_all($patternHref, $dataForm, $matchesHrefForm)) {
        $hrefForm = $matchesHrefForm[1];
    }

    // 匹配数据库数据并取得数据
    if (preg_match_all($patternHref, $dataSql, $matchesHrefSql)) {
        $hrefSql = $matchesHrefSql[1];
    }

    // 如果表单数据不为空的话就去和数据库作对比并删除不需要进行删除的数据;
    if (!empty($hrefForm) && !empty($hrefSql)) {
        if (is_array($hrefForm) && is_array($hrefSql)) {
            $hrefIntersect = array_intersect($hrefForm, $hrefSql); // 取得交集
            $hrefDiffer    = array_diff($hrefSql, $hrefIntersect); // 取得差集
            $differ        = array_merge($differ, $hrefDiffer); // 合并数组并统一赋值给 $differ
        }
    }

    // 如果进行处理后的数据不为空则执行删除操作
    if (!empty($differ) && is_array($differ)) {
        foreach ($differ as $value) {
            $urlarr = parse_url($value);
            $path   = $urlarr['path'];
            if (is_file('.' . $path)) {
                unlink('.' . $path);
            }
        }
    }

}

/**
 * 取得关键词，分词
 * @param  string    $str        [需要分词的字符串]
 * @param  string    $lenght     [分文词长度，默认为5个]
 * @param  string    $separator  [分隔符，默认为英文的逗号]
 * @return string    $tags       [返回分词]
 * @author SpringYang <ceroot@163.com>
 */
function get_keywords($str, $lenght = 10, $separator = ',')
{
    $str = strip_tags($str); // 去掉 html 代码
    $str = preg_replace('/[ ]/', '', $str);
    $str = str_replace('&nbsp;', '', $str); // 去掉 &nbsp;

    $pscws      = new \scws\Pscws();
    $extendPath = Env::get('extend_path');

    $pscws->set_dict($extendPath . 'scws/lib/dict.utf8.xdb');
    $pscws->set_rule($extendPath . 'scws/lib/rules.utf8.ini');
    $pscws->set_ignore(true);
    $pscws->send_text($str);
    $words = $pscws->get_tops($lenght);
    $pscws->close();

    $end  = end($words);
    $tags = '';
    foreach ($words as $val) {
        if ($val != $end) {
            $tags .= $val['word'] . $separator;
        } else {
            $tags .= $val['word'];
        }
    }
    return $tags;
}

/**
 * 取得描述
 * @param  string    $str          [需要分词的字符串]
 * @param  string    $lenght       [分文词长度，默认为120个]
 * @return string    $description  [返回描述]
 * @author SpringYang <ceroot@163.com>
 */
function get_description($str, $lenght = 120)
{
    $pattern = '/<p[^>]*>(.*?)<\/p>/'; // 因为 ueditor 是以 p 标签来做段落
    $preg    = preg_match($pattern, $str, $matches);
    // 当能够正常匹配的时候就使用匹配的值，当不能匹配的时候取默认值
    if ($preg) {
        $description = mb_substr(strip_tags($matches[1]), 0, $lenght);
        if (empty($description)) {
            $description = mb_substr(strip_tags($str), 0, $lenght);
        }
    } else {
        $description = mb_substr(strip_tags($str), 0, $lenght);
    }

    $description = str_replace(' ', '', $description); // 去掉空格
    $description = str_replace('&nbsp;', '', $description); // 去掉 &nbsp
    return $description;
}
