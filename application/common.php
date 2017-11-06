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

use app\facade\User;
use think\facade\Request;

/**
 * { getBroswer 获取客户端浏览器信息}
 * @Author   SpringYang
 * @DateTime 2017-10-23T11:55:15+0800
 * @return   [string]                   [description]
 */
function getBroswer()
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
        $exp[1] = "";
    }
    return $exp[0] . '(' . $exp[1] . ')';
}

/**
 * {getOs 获取客户端操作系统信息包括win10}
 * @Author   SpringYang
 * @DateTime 2017-10-23T11:54:39+0800
 * @return   [string]                   [description]
 */
function getOs()
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

/**
 * [ip2int ip地址转换为int]
 * @param   string  $ip  [ip地址]
 * @return  int          [返回整形数字]
 * @author  SpringYang <ceroot@163.com>
 */
function ip2int($ip = '')
{
    if ($ip == '') {
        $ip = Request::ip();
    }
    return sprintf("%u", ip2long($ip));
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
function authcode($str, $type = '')
{
    $authcode = new \authcode\Authcode();

    $code    = '';
    $restr_a = '+'; // 加密后有加号
    $tostr_a = '-'; // 使用减号替换加号
    $restr_b = '/'; // 加密后有斜扛
    $tostr_b = '^'; // 使用^替换斜扛

    if ($type === '') {
        $type  = 'CODE';
        $code  = $authcode->authcode($str, $type);
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

        $code = $authcode->authcode($str, $type);
    }
    return $code;
}

/**
 * deauthcode  解密 authcode 进行加密的字符串
 * @param str string    // 字符串
 */
function deauthcode($str)
{
    return authcode($str, 'DECODE');
}

/**
 * [ encrypt_password 密码加密 ]
 * @Author   SpringYang
 * @Email    ceroot@163.com
 * @DateTime 2017-10-24T17:35:25+0800
 * @param    string                   $password [description]
 * @param    string                   $salt     [description]
 * @return   string                             [description]
 */
function encrypt_password($password, $salt)
{
    return '' === $password ? '' : md5(sha1($password) . sha1($salt));
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data)
{
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 退出 url
 * @return     string  [url地址]
 * @author SpringYang <ceroot@163.com>
 */
function logouturl()
{
    // $loginout = url('Login/loginout') . '?backurl=' . getbackurl();
    $loginout = url('console/start/logout?time=' . date('YmdHis') . getrandom(128)) . '?backurl=' . getbackurl();
    return $loginout;
}

/**
 * getcurrenturl  取得当前url并转换成asc
 * 退出 url
 * @param  boolean     $suffix  [是否带后缀，默认还后缀]
 * @return string               [url地址]
 * @author SpringYang <ceroot@163.com>
 */
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

/**
 * 时间戳格式化
 * @param  int     $time   [时间]
 * @param  string  $format [时间格式]
 * @return string          [返回时间显示格式]
 * @author SpringYang <ceroot@163.com>
 */
function time_format($time = null, $format = 'Y-m-d H:i:s')
{
    if (empty($time)) {
        $time = time();
    }
    return date($format, intval($time));
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

/**
 * 生成树形结构数组
 * @param  array   $cate  传入数组
 * @param  string  $pid   传入父id
 * @return array   $arr   返回数组
 */
function getCateTreeArr($cate, $pid)
{
    $arr = array();
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
    $arr = array();
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
