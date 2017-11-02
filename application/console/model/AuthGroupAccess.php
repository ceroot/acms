<?php
namespace app\console\model;

use app\common\model\Extend;

class AuthGroupAccess extends Extend
{
    /**
     * @name   saveData             [保存数据]
     * @author SpringYang <ceroot@163.com>
     */
    public function saveData($uid, $groupid)
    {
        $this->delDataByUid($uid); // 先删除原有的

        $data['uid']      = $uid;
        $data['group_id'] = $groupid;
        $this->save($data);
    }

    /**
     * @name   delDataByUid         [根据用户id删除数据]
     * @param  string   $uid        [用户id]
     * @return boolean              [返回布尔值]
     * @author SpringYang <ceroot@163.com>
     */
    public function delDataByUid($uid)
    {
        $this->where('uid', $uid)->delete();
    }

    /**
     * @name   delDataByUid         [根据角色id删除数据]
     * @param  string   $gid        [角色id]
     * @return boolean              [返回布尔值]
     * @author SpringYang <ceroot@163.com>
     */
    public function delDataByGid($gid)
    {
        $this->where('group_id', $gid)->delete();
    }
}
