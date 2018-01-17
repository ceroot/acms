<?php
namespace app\console\model;

use app\common\model\Extend;

class AuthGroupAccess extends Extend
{
    /**
     * [ saveData 保存数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:02:47+0800
     * @param    integer                  $uid     [用户 id]
     * @param    integer                  $groupid [组 id]
     * @return   [type]                            [description]
     */
    public function saveData($uid, $groupid)
    {
        $this->delDataByUid($uid); // 先删除原有的

        $data['uid']      = $uid;
        $data['group_id'] = $groupid;
        $this->save($data);
    }

    /**
     * [ delDataByUid 根据用户id删除数据 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:04:09+0800
     * @param    integer                   $uid [用户id]
     * @return   [type]                        [description]
     */
    public function delDataByUid($uid)
    {
        $this->where('uid', $uid)->delete();
    }

    /**
     * [ delDataByUid 根据角色id删除数据 ]
     * @author   SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T13:04:39+0800
     * @param    integer                  $gid [角色 id]
     * @return   [type]                        [description]
     */
    public function delDataByGid($gid)
    {
        $this->where('group_id', $gid)->delete();
    }
}
