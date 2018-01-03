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
 * @filename  Document.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-11-29 10:33:12
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\controller;

use app\console\controller\Base;

class Document extends Base
{
    public function initialize()
    {
        parent::initialize();

        $category = $this->app->model('category')->where('status', 1)->select();
        $this->assign('category', $category);

        $db         = db('model');
        $model_id   = $db->getFieldByName('document', 'id');
        $model_list = db('model')->where('extend', $model_id)->select();
        // dump($model_list);
        $this->assign('model_list', $model_list);
        // die;

    }

    /**
     * [ renew 通用更新数据操作方法 ]
     * @author   SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T15:43:40+0800
     * @return   [type]                   [description]
     */
    public function renew11()
    {
        return 123;
        return $this->_renew();
    }
}
