<?php
namespace app\console\model;

use app\common\model\Extend;
use think\facade\Request;
use think\facade\Session;
use think\model\concern\SoftDelete;

class Action extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * [ add_for_rule 这里是给添加规则时是否添加操作记录调用的 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-11-01T17:47:06+0800
     */
    public function add_for_rule()
    {

        if (Request::isPost()) {

            $name = Request::param('name'); // 取得规则名称

            $arr = explode('/', $name);

            ///$controller = toUnderline($arr[0]);
            if (count($arr) < 1) {
                return false;
            }
            $name  = strtolower($arr[0] . '_' . $arr[1]);
            $title = Request::param('title'); // 取得规则标题

            $data['title']      = $title;
            $data['name']       = $name;
            $data['create_uid'] = Session::get('manager_id');
            $data['log']        = '[user|get_realname]在[time|time_format]操作了' . $title;

            $this->save($data);
        }
    }

}
