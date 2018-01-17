<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2016 http://beneng.com All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 * @filename  Config.php[配置表模型]
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2016-06-19 12:28:02
 * @site      http://www.benweng.com
 */

namespace app\common\model;

use app\common\model\Extend;
use think\Db;
use think\facade\Cache;
use think\facade\Config as Cfg;

class Config extends Extend
{

    public function getGroupAttr($value, $data)
    {
        // $group = [
        //     0 => '不分组',
        //     1 => '系统',
        //     2 => '后台',
        //     3 => '前台',
        //     4 => '网站',
        // ];
        $group = Cfg::set('config_group_list');
        return $group[$data['group']];
    }

    public function getTypeAttr($value, $data)
    {
        // $type = [
        //     0  => '其它',
        //     1  => '文本',
        //     2  => '文本域',
        //     3  => '标签',
        //     4  => '日期',
        //     5  => '颜色',
        //     6  => '图片',
        //     7  => '文件',
        //     8  => '多选',
        //     9  => '单选',
        //     10 => '下拉',
        //     11 => '数组',
        //     12 => '富文本',
        // ];
        $type = Cfg::get('config_type_list');
        return $type[$data['type']];
    }

    /**
     * [ cache_config 设置配置缓存 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:49:03+0800
     * @return   [type]                   [description]
     */
    public function cache_config()
    {
        $map = [
            ['status', '=', 1],
        ];
        $data = Db::name('config')->where($map)->field('type,name,value')->select();

        $config = [];
        if ($data && is_array($data)) {
            foreach ($data as $value) {
                switch (strtolower($value['name'])) {
                    case 'app_debug':
                        if ($value['value'] == 0) {
                            $value['value'] = false;
                        } else {
                            $value['value'] = true;
                        }
                        break;
                    case 'show_page_trace':
                        if ($value['value'] == 0) {
                            $value['value'] = false;
                        } else {
                            $value['value'] = true;
                        }
                        break;
                    case 'develop_mode':
                        if ($value['value'] == 0) {
                            $value['value'] = false;
                        } else {
                            $value['value'] = true;
                        }
                        break;
                    default:
                        # code...
                        break;
                }
                $config[$value['name']] = self::parse($value['type'], $value['value']);
            }
        }
        Cache::set('db_config_data', $config);
        return $config;
    }

    /**
     * 根据配置类型解析配置
     * @param  integer $type  配置类型
     * @param  string  $value 配置值
     */
    private static function parse($type, $value)
    {
        switch ($type) {
            case 'array': //解析数组
                $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
                if (strpos($value, ':')) {
                    $value = array();
                    foreach ($array as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k]   = $v;
                    }
                } else {
                    $value = $array;
                }
                break;
        }
        return $value;
    }
}
