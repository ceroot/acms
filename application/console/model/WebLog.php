<?php
namespace app\console\model;

use app\common\model\Extend;
use think\model\concern\SoftDelete;

class WebLog extends Extend
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}
