<?php
/**
 * Description of models.php.
 * User: static7 <static7@qq.com>
 * Date: 2017-04-29 18:25
 */

namespace app\common\traits;

use think\facade\App;

trait Models
{
    //定义错误信息
    protected $error;

    /**
     * [ getError 返回模型的错误信息 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2018-01-17T11:53:55+0800
     * @return   string|array                   [description]
     */
    public function getError()
    {
        return $this->error;
    }

}
