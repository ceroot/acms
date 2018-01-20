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
 * @filename  Document.php 文档逻辑
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-10 23:09:46
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\common\logic;

use think\Db;
use think\Model;

class Document extends Model
{
    /**
     * [ getReader function_description ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:45:59+0800
     * @param    integer                  $id [文档 id]
     * @return   array                        [返回文档数据]
     */
    public function getReader($id)
    {
        $data = Db::name('Document')->where('status', 1)->find($id);
        if (!$data) {
            return false;
        }
        // dump($data);
        $modelId           = $data['model_id'];
        $coverId           = $data['cover_id'];
        $cid               = $data['cid'];
        $cid_title         = Db::name('Category')->getFieldById($cid, 'title');
        $data['cid_title'] = $cid_title;
        $template          = $data['template'] ?: 'reader';
        $data['template']  = $template;

        $coverData     = Db::name('picture')->find($coverId);
        $data['cover'] = $coverData['path'];

        if ($modelId) {
            $documentModelData = Db::name('model')->find($modelId);
            $extendId          = $documentModelData['extend'];
            $extendName        = $documentModelData['name'];
            $name              = Db::name('model')->getFieldById($extendId, 'name');
            $extendData        = Db::name($name . '_' . $extendName)->find($data['id']);
            $data['extend']    = $extendData;
        }

        return $data;
    }
}
