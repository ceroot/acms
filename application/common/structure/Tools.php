<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Tools.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-25 11:06:39
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\structure;

use app\common\traits\Models;
use think\Db;
use think\facade\Request;

class Tools
{
    use Models;

    /**
     * [ __construct 初始化 ]
     * @Author   SpringYang
     * @Email    ceroot@163.com
     * @DateTime 2017-11-23T14:13:18+0800
     */
    public function __construct()
    {

    }

    public function test()
    {
        return 123;
    }

    /**
     * [ checkRemoteFileExists 判断远程文件是否存在 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-29T16:55:19+0800
     * @param    [type]                   $url [远程文件 url]
     * @return   [type]                        [description]
     */
    public static function checkRemoteFileExists($url)
    {
        $found = false;

        if (function_exists('curl_init')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_NOBODY, true); // 不取回数据
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // 不加这个会返回403，加了才返回正确的200，原因不明

            $result = curl_exec($curl); // 发送请求
            // 如果请求没有发送失败
            if ($result !== false) {
                // 再检查http响应码是否为 200
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($statusCode == 200) {
                    $found = true;
                }
            }
            curl_close($curl);
        } else {
            $headers = get_headers($url, 1);
            if (preg_grep('/200/', $headers)) {
                $found = true;
            }
        }
        return $found;
    }

    /**
     * [ saveRemoteFile 保存远程文件 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-29T16:54:47+0800
     * @param    string                   $url       [远程文件 url]
     * @param    string                   $fileName  [要保存的文件名称（带后缀）]
     * @param    string                   $savePath  [description]
     * @return   string                              [返回保存在本地的路径]
     */
    public static function saveRemoteFile($url, $fileName, $savePath = '')
    {
        if (!self::checkRemoteFileExists($url)) {
            // throw new \think\exception\HttpException(404, '远程文件不存在');
            return false;
        };

        $fileContent = url_get_contents($url);
        make_dir($savePath);
        $saveFilePath = $savePath . $fileName;
        $saveFile     = fopen($saveFilePath, 'w');
        fwrite($saveFile, $fileContent);
        fclose($saveFile);
        return $saveFilePath;
    }

    /**
     * [ isImagesUrl 判断 url 地址是否是图片地址，如果是就返回图片格式 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T10:36:36+0800
     * @param    string                   $url [url 地址]
     * @return   boolean                       [description]
     */
    public static function isImagesUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //是否跟着爬取重定向的页面
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将curl_exec()获取的值以文本流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_HEADER, 1); // 启用时会将头文件的信息作为数据流输出
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); //设置超时时间
        curl_setopt($ch, CURLOPT_URL, $url); //设置URL
        $content    = curl_exec($ch);
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE); //curl的httpcode
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE); //获取头大小
        curl_close($ch);

        $headers = substr($content, 0, $headerSize);
        // 判断返回 headers
        if ($headers) {
            $head_data = preg_split('/\n/', $headers); //逐行放入数组中
            $head_data = array_filter($head_data); //过滤空数组

            // 取得 Content-Type
            $contentType = '';
            foreach ($head_data as $val) {
                //按:分割开
                if (stripos($val, ':')) {
                    list($k, $v) = explode(":", $val); //:前面的作为key，后面的作为value，放入数组中
                    if ('content-type' == strtolower($k)) {
                        $contentType = trim($v);
                        break;
                    }
                }
            }

            if ($contentType) {
                $img_type = explode("/", $contentType); //然后将获取到的 Content-Type 值用/分隔开
                if ($httpcode == 200 && strcasecmp($img_type[0], 'image') == 0) {
                    //如果httpcode为200，并且Content-type前面的部分为image，则说明该链接可以访问成功，并且是一个图片类型的
                    $type = $img_type[1];
                    return $type;
                } else {
                    //否则........
                    return false;
                }
            }
        }
    }

    /**
     * [ urlGetContents 取得 url 内容 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T10:39:25+0800
     * @param    string                   $url [url 地址]
     * @return   [type]                        [description]
     */
    public static function urlGetContents($url)
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

    /**
     * [ isLocal 判断 ip 是内网还是外网 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-28T10:34:40+0800
     * @param    [type]                   $ip [ip 地址]
     * @return   boolean                      [description]
     */
    public static function isLocal($ip = null)
    {
        $ip = $ip ?: Request::ip();
        return preg_match('%^127\.|10\.|192\.168|172\.(1[6-9]|2|3[01])%', $ip); // 正则方式
        //return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE); // PHP 自带判断私有ip 方法
    }

    /**
     * [ getRandom 取得随机数 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-12T10:43:55+0800
     * @param    integer                  $length  [随机数长度]
     * @param    integer                  $numeric [类型 0为数字，1为全部，2为大小写，3为数字加大写，4为数字加小写，5为大写，6为小写，7为uniqid()]
     * @return   string                   $hash    [返回字符串]
     */
    public static function getRandom($length = 6, $numeric = 0)
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
     * 返回多层栏目
     * @param $data 操作的数组
     * @param int $pid 一级PID的值
     * @param string $html 栏目名称前缀
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     * @param int $level 不需要传参数（执行时调用）
     * @return array
     */
    public static function channelLevel($data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
    {
        if (empty($data)) {
            return array();
        }
        $arr = array();
        foreach ($data as $v) {
            if ($v[$fieldPid] == $pid) {
                $arr[$v[$fieldPri]]           = $v;
                $arr[$v[$fieldPri]]['_level'] = $level;
                $arr[$v[$fieldPri]]['_html']  = str_repeat($html, $level - 1);
                $arr[$v[$fieldPri]]["_data"]  = self::channelLevel($data, $v[$fieldPri], $html, $fieldPri, $fieldPid, $level + 1);
            }
        }
        return $arr;
    }

    /**
     * 获得所有子栏目
     * @param $data 栏目数据
     * @param int $pid 操作的栏目
     * @param string $html 栏目名前字符
     * @param string $fieldPri 表主键
     * @param string $fieldPid 父id
     * @param int $level 等级
     * @return array
     */
    public static function channelList($data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
    {
        $data = self::_channelList($data, $pid, $html, $fieldPri, $fieldPid, $level);
        if (empty($data)) {
            return $data;
        }

        foreach ($data as $n => $m) {
            if ($m['_level'] == 1) {
                continue;
            }

            $data[$n]['_first'] = false;
            $data[$n]['_end']   = false;
            if (!isset($data[$n - 1]) || $data[$n - 1]['_level'] != $m['_level']) {
                $data[$n]['_first'] = true;
            }
            if (isset($data[$n + 1]) && $data[$n]['_level'] > $data[$n + 1]['_level']) {
                $data[$n]['_end'] = true;
            }
        }
        //更新key为栏目主键
        /*   $category=array();
        foreach($data as $d){
        $category[$d[$fieldPri]]=$d;
        }*/
        return $data;
    }

    //只供channelList方法使用
    private static function _channelList($data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
    {
        if (empty($data)) {
            return array();
        }

        $arr = array();
        foreach ($data as $v) {
            $id = $v[$fieldPri];
            if ($v[$fieldPid] == $pid) {
                $v['_level'] = $level;
                $v['_html']  = str_repeat($html, $level - 1);
                array_push($arr, $v);
                $tmp = self::_channelList($data, $id, $html, $fieldPri, $fieldPid, $level + 1);
                $arr = array_merge($arr, $tmp);
            }
        }
        return $arr;
    }

    /**
     * 获得树状数据
     * @param $data 数据
     * @param $title 字段名
     * @param string $fieldPri 主键id
     * @param string $fieldPid 父id
     * @return array
     */
    public static function tree($data, $title, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        if (!is_array($data) || empty($data)) {
            return [];
        }

        $arr = self::channelList($data, 0, '', $fieldPri, $fieldPid);
        foreach ($arr as $k => $v) {
            $str = "";
            if ($v['_level'] > 2) {
                for ($i = 1; $i < $v['_level'] - 1; $i++) {
                    $str .= "│&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            if ($v['_level'] != 1) {
                $t = $title ? $v[$title] : "";
                if (isset($arr[$k + 1]) && $arr[$k + 1]['_level'] >= $arr[$k]['_level']) {
                    $arr[$k]['_name'] = $str . "├─ " . $v['_html'] . $t;
                } else {
                    $arr[$k]['_name'] = $str . "└─ " . $v['_html'] . $t;
                }
            } else {
                $arr[$k]['_name'] = $v[$title];
            }
        }
        //设置主键为$fieldPri
        $data = [];
        foreach ($arr as $d) {
            $data[$d[$fieldPri]] = $d;
        }
        return $data;
    }

    /**
     * 获得所有父级栏目
     * @param $data 栏目数据
     * @param $sid 子栏目
     * @param string $fieldPri 唯一键名，如果是表则是表的主键
     * @param string $fieldPid 父ID键名
     * @return array
     */
    public static function parentChannel($data, $sid, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        if (empty($data)) {
            return $data;
        } else {
            $arr = array();
            foreach ($data as $v) {
                if ($v[$fieldPri] == $sid) {
                    $arr[] = $v;
                    $_n    = self::parentChannel($data, $v[$fieldPid], $fieldPri, $fieldPid);
                    if (!empty($_n)) {
                        $arr = array_merge($arr, $_n);
                    }
                }
            }
            return $arr;
        }
    }

    /**
     * 判断$s_cid是否是$d_cid的子栏目
     * @param $data 栏目数据
     * @param $sid 子栏目id
     * @param $pid 父栏目id
     * @param string $fieldPri 主键
     * @param string $fieldPid 父id字段
     * @return bool
     */
    public static function isChild($data, $sid, $pid, $fieldPri = 'cid', $fieldPid = 'pid')
    {
        $_data = self::channelList($data, $pid, '', $fieldPri, $fieldPid);
        foreach ($_data as $c) {
            //目标栏目为源栏目的子栏目
            if ($c[$fieldPri] == $sid) {
                return true;
            }

        }
        return false;
    }

    /**
     * 检测是不否有子栏目
     * @param $data 栏目数据
     * @param $cid 要判断的栏目cid
     * @param string $fieldPid 父id表字段名
     * @return bool
     */
    public static function hasChild($data, $cid, $fieldPid = 'pid')
    {
        foreach ($data as $d) {
            if ($d[$fieldPid] == $cid) {
                return true;
            }

        }
        return false;
    }

    /**
     * 递归实现迪卡尔乘积
     * @param $arr 操作的数组
     * @param array $tmp
     * @return array
     */
    public static function descarte($arr, $tmp = array())
    {
        static $n_arr = array();
        foreach (array_shift($arr) as $v) {
            $tmp[] = $v;
            if ($arr) {
                self::descarte($arr, $tmp);
            } else {
                $n_arr[] = $tmp;
            }
            array_pop($tmp);
        }
        return $n_arr;
    }

    // $string： 明文 或 密文
    // $operation：DECODE表示解密,其它表示加密
    // $key： 密匙
    // $expiry：密文有效期
    public function authCode($string, $operation = 'DECODE', $key = 'cy_auth_key', $expiry = 0)
    {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 4;

        // 密匙
        $key = md5($key ? $key : $GLOBALS['cy_auth_key']);

        // 密匙a会参与加解密
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙
        $cryptkey   = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string        = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result        = '';
        $box           = range(0, 255);
        $rndkey        = array();
        // 产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // substr($result, 0, 10) == 0 验证数据有效性
            // substr($result, 0, 10) - time() > 0 验证数据有效性
            // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
            // 验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * [ getPrevNextId 根据 id 取得上一项下一项的 id ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-12-29T17:56:04+0800
     * @param    string                   $table  [表名]
     * @param    integer                  $id     [当前 id]
     * @param    integer                  $type   [类型，0 为上一条，1 为下一条]
     * @return   [type]                           [description]
     */
    public static function getPrevNextId($table, $id, $type = 0)
    {
        $tempId = $id;
        if ($type) {
            $id     = $id + 1;
            $tipsId = Db::name($table)->max('id');
            $tips   = '未来在路上，请稍等……';
        } else {
            $id     = $id - 1;
            $tipsId = Db::name($table)->min('id');
            $tips   = '已经是第一个了';
        }

        if ($tempId == $tipsId) {
            return $tips;
        }

        $data = Db::name($table)->where('status', 1)->find($id);

        if (!$data) {
            self::getPrevNextId($table, $id, $type);
        } else {
            return $id;
        }

    }

}
