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
 * @filename  WebLog.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-23 10:56:57
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\model;

use app\common\model\Extend;
use think\model\concern\SoftDelete;

class WebLog extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * [ getFromAttr 取得来自地区，待完善 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:51:00+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $data  [description]
     * @return   [type]                          [description]
     */
    public function getFromAttr($value, $data)
    {
        $ip     = long2ip($data['create_ip']);
        $url    = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip;
        $result = url_get_contents($url);
        $result = json_decode($result, true);
        if ($result['code'] !== 0 || !is_array($result['data'])) {
            return false;
        }
        $ipInfo = $result['data'];
        return $ipInfo['region'] . $ipInfo['city'] . ' | ' . $ipInfo['isp'];
    }

}
