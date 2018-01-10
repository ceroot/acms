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

namespace app\index\controller;

use app\common\controller\Extend;
use think\Db;

class Document extends Extend
{
    public function initialize()
    {
        parent::initialize();

        $category = Db::name('Document')->where('status', 1)->select();

    }

    public function index()
    {
        $data = Db::name('Document')->where('status', 1)->limit(2)->select();
        dump($data);
    }

    public function reader($id)
    {
        $id || $this->error('参数错误');
        // $id                = deauthor($id);
        $data = Db::name('Document')->where('status', 1)->find($id);

        $modelId          = $data['model_id'];
        $coverId          = $data['cover_id'];
        $template         = $data['template'] ?: 'reader';
        $data['template'] = $template;

        $coverData     = Db::name('picture')->find($coverId);
        $data['cover'] = $coverData['path'];

        $documentModelData = Db::name('model')->find($modelId);
        $extendId          = $documentModelData['extend'];
        $extendName        = $documentModelData['name'];
        $name              = Db::name('model')->getFieldById($extendId, 'name');
        $extendData        = Db::name($name . '_' . $extendName)->find($data['id']);
        $data['extend']    = $extendData;

        dump($data);

    }

}
