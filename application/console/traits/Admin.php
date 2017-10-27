<?php

namespace app\console\traits;

use think\facade\Request;
use traits\controller\Jump;

trait Admin
{
    use Jump;

    public function bindContainer()
    {

    }

    /**
     * [ listsData 列表数据处理 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-27T16:26:28+0800
     * @return   [type]                   [description]
     */
    protected function listsData()
    {
        $data      = Request::param(); // 获得 post 数据
        $pageLimit = Request::param('limit'); // 取得每页数量
        $search    = Request::param('search'); // 搜索标记
        $page      = Request::param('page');
        $like      = Request::param('like'); // 字段模糊查询标记
        //
        //$data      = input('param.'); // 获得 post 数据
        //$pageLimit = input('param.limit'); // 取得每页数量
        //$search    = input('param.search'); // 搜索标记
        //$page      = input('param.page');
        //$like      = input('param.like'); // 字段模糊查询标记
        $map = [];
        // return $data;
        // $search = 1; // 搜索标记
        //

        $pageLimit = isset($pageLimit) ? $pageLimit : config('paginate.list_rows'); //15; // 每页显示数目
        // $pageLimit = 2;
        if (!$this->model) {
            return $this->error('请增加控制规则', url('authRule/add'));
        }

        // 默认排序
        $order = [
            $this->pk => 'desc',
        ];

        // 查询条件

        if ($search) {

            $tableFields = $this->model->getTableFields(); // 取得表字段

            // 重组 post 字段，只取键名
            $mapFields = [];
            foreach ($data as $key => $value) {
                $mapFields[] = $key;
            }

            $intersect = array_intersect($mapFields, $tableFields); // 取得 post 字段与表字段差集，去掉多余的查询字段

            // 重组 post 数据
            foreach ($intersect as $value) {
                if ($data[$value]) {
                    $map[$value] = $data[$value];
                }

                if ($value == $like) {
                    $map[$value] = array('like', '%' . $data[$value] . '%');
                }

            }

            // 不同模型的处理
            switch (request()->controller()) {
                case 'Manager':
                    break;
                case 'Config11':
                    # code...
                    $map['group'] = input('param.group');
                    if (!input('?param.group')) {
                        unset($map['group']);
                    }
                    break;
                case '2':
                    # code...
                    break;
                case '3':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }

        }

        // 各种条件
        switch (request()->controller()) {
            case 'Manager':
                $order = [
                    $this->pk => 'asc',
                ];
                break;
            case 'Config111':
                $order = [
                    'group' => 'desc',
                ];
                $map['group'] = input('param.group');
                if (!input('?param.group')) {
                    unset($map['group']);
                }
                break;
            case 'attribute':
                $model_id        = input('param.model_id');
                $map['model_id'] = $model_id;
                break;
            default:
                # code...
                break;
        }

        $list = '';
        //$list = $this->model->where($map)->order($order)->paginate($pageLimit, false, ['query' => get_query()]);
        $list  = $this->model->where($map)->order($order)->paginate($pageLimit, false, ['page' => $page, 'list_rows' => $pageLimit]); // 数据查询
        $count = $this->model->where($map)->count(); // 总计数

        // 给数组添加编辑 editid 并加密，本来是想在里自动实现的，可是模型里自动实现的在layui里无法输出，所以在这里再做一次操作
        $newList     = [];
        $relationTag = false; // 模型关联标记，用以是否使用关联查询处理
        if ($list) {
            foreach ($list as $value) {
                switch (strtolower(request()->controller())) {
                    case 'manager': // 管理员模型关联
                        $relationTag  = true;
                        $relationId   = $value['id']; // 关联 id
                        $relationName = 'UcenterMember'; // 关联定义方法名
                        break;
                    default:
                        # code...
                        break;
                }

                // 模型关联处理
                if ($relationTag) {
                    $value = $this->model::get($relationId, $relationName); // 关联预载入查询
                    unset($value[toUnderline($relationName)]); // 去掉关联数据
                }

                $value->editid = authcode($value['id']); // 增加编辑 editid 并加密

                // 开发模式判断
                if (!config('app_debug')) {
                    unset($value['id']);
                }
                $newList[] = $value;
            }
        }
        $redata['count'] = $count;
        $redata['data']  = $newList;
        return $redata;
    }

}
