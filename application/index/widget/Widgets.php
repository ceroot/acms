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
 * @filename  Widget.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-15 15:27:17
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\index\widget;

use app\common\controller\Extend;
use app\facade\Tools;
use think\Db;

class Widgets extends Extend
{
    /**
     * [ documentsidebar 文档侧边栏归类 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-15T17:00:51+0800
     * @return   [type]                   [description]
     */
    public function documentsidebar()
    {
        $startDate = Db::name('Document')->min('create_time'); // 取得最小值，也就是开始的值
        $startDate = date('Y-m-d', $startDate);
        $startDate = strtotime($startDate); // 自动为00:00:00 时分秒
        $endDate   = time(); // 当前时间
        $monArr[]  = date('Y-m', $startDate); // 数组开始

        // 取得月份数据
        while (($startDate = strtotime('+1 month', $startDate)) <= $endDate) {
            $monArr[] = date('Y-m', $startDate); // 取得递增月;
        }
        rsort($monArr); // 排序

        // 取得统计数据
        $gl = [];
        foreach ($monArr as $value) {
            $value       = date('Ymd', strtotime($value));
            $getthemonth = Tools::getFirstLastDayMonth($value); // 取得当月的第一天和最后一天
            // 查询条件
            $where = [
                ['create_time', 'between time', [$getthemonth[0], $getthemonth[1]]],
            ];
            $count = Db::name('Document')->where('status', 1)->whereBetweenTime('create_time', $getthemonth[0], $getthemonth[1])->count();

            $tempD['month'] = strtotime($value);
            $tempD['count'] = $count;
            $gl[]           = $tempD;
        }

        $this->assign('gl', $gl);
        return $this->fetch('widget/documentsidebar');
    }
}
