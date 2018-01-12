<?php
/**
 *
 * @authors SpringYang (ceroo@163.com)
 * @date    2018-01-10 23:09:46
 * @version $Id$
 */
namespace app\common\logic;

use app\common\model\Extend;
use think\Db;

class Document extends Extend
{
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
