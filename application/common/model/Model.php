<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Model.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-04 10:53:26
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\common\model;

use think\Db;
use think\facade\Request;
use think\Model as ModelModel;

class Model extends ModelModel
{
    public function getList()
    {

    }

    /**
     * [ getModelInfoByName 根据 name 查询数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-03-08T15:32:20+0800
     * @param    string                   $name    [description]
     * @return   array                    $redata  [description]
     */
    public function getModelInfoByName($name)
    {
        $model_data = $this->where('name', $name)->find(); // 查找模型数据
        $model_data || $this->error('参数错误');

        $extend_name = $this->getFieldById($model_data['extend'], 'name'); // 取得主表名称
        $redata[]    = $model_data['id']; // 取得模型 id 【model_id】
        $redata[]    = $extend_name . '_' . $model_data['name']; // 取得模型名称【model_name】
        $redata[]    = $extend_name; // 继承表名称【extend_name】

        return $redata;
    }

    /**
     * [ getModelInfoById 根据 id 查询数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-03-08T15:31:54+0800
     * @param    intger                   $id      [description]
     * @return   array                    $redata  [description]
     */
    public function getModelInfoById($id)
    {
        $model_data = $this->get($id);
        $model_data || $this->error('参数错误');
        $name        = $model_data->getAttr('name');
        $extend_id   = $model_data->getAttr('extend');
        $extend_name = $this->getFieldById($extend_id, 'name');

        $redata['id']          = $id; // id
        $redata['name']        = $name; // 名称
        $redata['extend_id']   = $extend_id; // 继承 id
        $redata['extend_name'] = $extend_name; // 继承 name
        $redata['all_name']    = $extend_name . '_' . $name; // 完整名称

        return $redata;
    }

    /**
     * [ modelExtend 继承处理 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-03T12:18:42+0800
     * @param    array                   $data  [description]
     * @return   [type]                         [description]
     */
    public function modelExtend($data = null)
    {
        $model_data = $this->getModelInfoById($data['model_id']);
        $name       = $model_data['name'];
        $db         = Db::name($model_data['all_name']);
        $id         = $data['id'];

        // return $data;
        switch ($name) {
            case 'article':
                // 对 ueditor 内容数据的处理
                $data['content'] = ueditor_handle($data['content'], $data['title']);
                // return $data;
                break;
            case 'tickets':
                $data['introduction'] = ueditor_handle($data['introduction'], $data['title']);
                $data['drive']        = ueditor_handle($data['drive'], $data['title']);
                $data['bus']          = ueditor_handle($data['bus'], $data['title']);
                $data['notice']       = ueditor_handle($data['notice'], $data['title']);
                // return $data;
                break;
            default:
                # code...
                break;
        }

        // return $data;

        if (Request::has($this->pk)) {
            // 执行更新
            if ($result = $db->find($id)) {
                $status = $db->update($data);
                // return $data;
                if ($status) {
                    switch ($name) {
                        case 'article':
                            $contentForm = $data['content'];
                            if ($contentForm && $contentSqlTemp) {
                                // 对比判断并删除操作
                                $del_file = del_file($contentForm, $result['content']);
                            }
                            break;
                        case 'tickets':
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            } else {
                $status = $db->removeOption()->insertGetId($data);
            }
        } else {
            // return $data;
            $status = $db->insertGetId($data);
        }

        return $status;
    }

    public function getExtendDataById($id, $model_id)
    {
        $model_data = $this->getModelInfoById($model_id);
        $tempData   = Db::name($model_data['all_name'])->field('id', true)->find($id);

        return $tempData ? $tempData : false;
    }

}
