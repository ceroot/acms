<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2017 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Collection.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-12 11:31:47
 * @site      http://www.benweng.com
 * @version   $Id$
 */
namespace app\index\controller;

use think\Db;

class Collection
{
    private $uid;
    private $did;
    private $mid;
    private $db;
    private $where = [];
    private $data  = [];

    public function initialize()
    {
        $this->uid = '';
        $this->did = '';
        $this->mid = '';

        $this->db = Db::name('Collection');

        $this->where = [
            ['uid', '=', $this->uid],
            ['did', '=', $this->did],
            ['mid', '=', $this->mid],
        ];

        $this->data = [
            'uid' => $this->uid,
            'did' => $this->did,
            'mid' => $this->mid,
        ];

    }

    public function setvalue()
    {
        if (!$this->isCollection()) {
            $status = $this->db->insert($this->data);
            return $status ? '收藏成功' : '收藏失败';
        } else {
            return '已经收藏';
        }
    }

    public function cancel()
    {
        $status = $this->db->where($where)->useSoftDelete('delete_time', time())->delete();
        return $status ? '取消收藏成功' : '取消收藏失败';
    }

    public function isCollection()
    {
        $status = $this->db->where($this->where)->find();
        return $status ? true : false;
    }

}
