<?php
namespace app\console\traits;

use think\facade\Hook;
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
    protected function _lists()
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
        $pageLimit = isset($pageLimit) ? $pageLimit : $this->app->config->get('paginate.list_rows'); //15; // 每页显示数目
        // $pageLimit = 2;
        // dump($pageLimit);
        if (!$this->model) {
            return $this->error('请增加控制规则', url('authRule/add'));
        }
        // 默认排序
        $order = [
            $this->pk => 'desc',
        ];

        // 各种条件
        switch (strtolower($this->request->controller())) {
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

        $list = '';

        // 超级管理员及软删除判断
        if ($this->isWithTrashed()) {
            $list  = $this->model->withTrashed()->where($map)->order($order)->paginate($pageLimit, false, ['page' => $page, 'list_rows' => $pageLimit]);
            $count = $this->model->withTrashed()->where($map)->order($order)->count(); // 总计数
        } else {
            $list  = $this->model->where($map)->order($order)->paginate($pageLimit, false, ['page' => $page, 'list_rows' => $pageLimit]);
            $count = $this->model->where($map)->order($order)->count(); // 总计数
        }
        dump($list);

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
                // dump($value);die;
                $value->editid = authcode($value['id']); // 增加编辑 editid 并加密

                // 开发模式判断
                if (!config('app_debug') && $this->app->session->get('manager_id') != 1) {
                    unset($value['id']);
                }
                $newList[] = $value;
            }
        }
        $redata['count'] = $count;
        $redata['data']  = $newList;
        // dump($redata);die;
        return $redata;
    }

    /**
     * [ _edit 通用编辑数据处理 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T14:07:36+0800
     * @return   [type]                   [description]
     */
    protected function _edit()
    {
        if (!$this->id) {
            return $this->error('参数错误');
        } else {
            switch (strtolower($this->app->request->controller())) {
                case 'manager': // 管理员编辑数据处理
                    $relationName = 'UcenterMember'; // 关联方法名称
                    if ($this->isWithTrashed()) {
                        $one = $this->model->withTrashed()->get($this->id, $relationName); // 关联预载入查询
                    } else {
                        $one = $this->model->get($this->id, $relationName); // 关联预载入查询
                    }

                    $one             = $one->getData(); // 取得原始数据
                    $gdata           = model('AuthGroupAccess')->where('uid', $this->id)->find(); // 查找管理员所属角色
                    $one['group_id'] = $gdata['group_id'];
                    unset($one[toUnderline($relationName)]); // 去掉关联数据
                    break;
                default:
                    if ($this->isWithTrashed()) {
                        $one = $this->model->withTrashed()->find($this->id);
                    } else {
                        $one = $this->model->find($this->id); // 取得数据
                    }
                    $one = $one->getData();
                    break;
            }

            $one['editid'] = authcode($one['id']); // 加密编辑 editid

            return $one;

        }
    }

    /**
     * [ _renew 通用更新数据操作方法的数据处理 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T14:00:21+0800
     * @return   [type]                   [description]
     */
    protected function _renew()
    {
        if ($this->app->request->isPost()) {
            $data  = $this->app->request->param();
            $scene = 'add'; // 验证场景，默认是新增
            // return $data;
            switch (strtolower($this->app->request->controller())) {
                case 'article':
                    // 封面图片处理
                    if ($data['cover']) {
                        $data['cover'] = $this->articleCover($data['cover']);

                    } else {
                        unset($data['cover']);
                    }
                    // 对 ueditor 内容数据的处理
                    $data['content'] = ueditor_handle($data['content'], $data['title']);
                    if (!$data['description']) {
                        $data['description'] = get_description($data['content']);
                    }
                    if (!$data['keywords']) {
                        $data['keywords'] = get_keywords($data['content']);
                    }
                    # code...
                    break;

                default:
                    # code...
                    break;
            }

            // return $data;

            // 判断是新增还是更新，如果有键值就是更新，如果没有键值就是新增
            if ($this->app->request->has($this->pk)) {
                // return $data;
                $data[$this->pk] = $this->id;
                if (!$this->id) {
                    return $this->error('参数错误');
                }

                // 各种模式下对数据的处理
                switch ($this->app->request->controller()) {
                    case 'Model':
                        if (input('param.field_sort/a')) {
                            $data['field_sort'] = json_encode($data['field_sort']);
                        }
                        if (input('param.attribute_list/a')) {
                            $data['attribute_list'] = arr2str($data['attribute_list']);
                        } else {
                            $data['attribute_list'] = '';
                        }
                        break;
                    case 'Article':
                        $old_file_cover = $this->model->getFieldById($this->id, 'cover');
                        if ($old_file_cover) {
                            $this->app->session->set('old_file', $old_file_cover);
                        }

                        $contentForm = $data['content'];
                        if ($contentForm) {
                            // $contentSql = $this->model->where('id', $data[$pk])->value('content');
                            $contentSql = $this->model->getFieldById($this->id, 'content');
                            if (!empty($contentSql)) {
                                // 对比判断并删除操作
                                $del_file = del_file($contentForm, $contentSql);
                            }
                        }

                        break;
                    default:
                        # code...
                        break;
                }

                // return $data;

                // 数据验证
                $validate = $this->app->validate($this->app->request->controller());
                if (!$validate->scene('edit')->check($data)) {
                    return $this->error($validate->getError());
                }

                // 数据保存
                $status = $this->model->save($data, [$this->pk => $this->id]);

                $scene = 'edit'; // 更改默认场景
            } else {
                // 数据验证
                // return $data;
                $validate = $this->app->validate($this->app->request->controller());
                if (!$validate->check($data)) {
                    return $this->error($validate->getError());
                }

                // 数据保存
                // return $data;
                $status = $this->model->save($data);
                // return 5;

            }

            // 数据保存不通过返回提示
            if ($status === false) {
                return $this->error($this->model->getError());
            }

            // 是否成功返回
            if ($status) {

                $pk        = $this->pk; // 取得数据库主键名称
                $record_id = $this->model->$pk; // 数据 id 值

                switch ($this->app->request->controller()) {
                    case 'AuthRule':
                        $this->model->updateCache(); // 更新规则缓存

                        // 新增时是否添加日志记录标记
                        if ($this->app->request->has('_log')) {
                            $this->app->model('Action')->add_for_rule();
                        }
                        break;
                    case 'Manager': // 管理员操作时的操作
                        // return $data;
                        model('AuthGroupAccess')->saveData($record_id);
                        break;
                    case 'Config': // 清空配置数据缓存
                        cache('db_config_data', null);
                        break;
                    case 'Model': // 清除模型缓存数据
                        cache('document_model_list', null);
                        break;
                    case 'Article': // 内容管理时的数据处理
                        // 封面图片处理
                        if ($this->app->request->param('cover')) {
                            $this->articleCover($data['cover'], 2);

                            // 删除旧封面处理
                            if ($this->app->session->has('old_file')) {
                                $old_file_cover = $this->app->session->pull('old_file');
                                $images_path    = './data/images/';
                                $old_file_path  = $images_path . $old_file_cover;
                                if (file_exists($old_file_path)) {
                                    unlink($old_file_path);
                                }
                            }

                        }
                        // return $data;
                        break;
                    default:
                        # code...
                        break;
                }

                $this->app->hook->listen('action_log', ['action' => $scene, 'record_id' => $record_id]); // 行为日志记录

                return $this->success($this->app->request->has($this->pk) ? '修改成功' : '新增成功', cookie('__forward__'));
            } else {
                return $this->error('操作失败');
            }
        } else {
            return $this->error('数据有误');
        }
    }

    /**
     * [ articleCover 内容管理对封面图片的处理 ]
     * @author SpringYang
     * @email    ceroot@163.com
     * @dateTime 2017-11-30T09:46:32+0800
     * @param    string                   $coverData [封面图像数据，type为1时是base64数据，type为2时是文件路径]
     * @param    int                      $type       [状态，1为开始（默认），2为成功之后]
     * @return   string                               []
     */
    private function articleCover($coverData = null, $type = 1)
    {
        $pathTemp   = '../data/temp/'; // 临时文件夹路径
        $pathImages = './data/images/'; // 图像文件文件夹路径

        if ($type == 1) {
            //匹配出图片的格式
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $coverData, $result)) {
                $type     = $result[2]; // 图像格式
                $pathTemp = '../data/temp/'; // 临时文件夹路径
                $dateFile = date('Ymd', time()) . '/'; // 日期目录

                $allPath = $pathTemp . $dateFile; // 全部路径

                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                if (!file_exists($allPath)) {
                    make_dir($allPath);
                }

                $filename = md5(time()) . '.' . $type; // md5加密后的文件名（带后缀）
                $filePath = $allPath . $filename; // 文件的位置
                if (file_put_contents($filePath, base64_decode(str_replace($result[1], '', $coverData)))) {
                    return $dateFile . $filename;
                } else {
                    return 0;
                }
            }
        } elseif ($type == 2) {
            $tempArr  = explode('/', $coverData); // 以/拆分数据
            $dateFile = $tempArr[0] . '/'; // 日期目录
            $filename = $tempArr[1]; // 文件名（带后缀）
            $allPath  = $pathImages . $dateFile; // 全部路径
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            if (!file_exists($allPath)) {
                make_dir($allPath);
            }

            $tempFilePath = $pathTemp . $coverData; // 临时文件位置

            // 检查文件是否存在
            if (file_exists($tempFilePath)) {
                $image = \think\Image::open($tempFilePath);
                if ($image) {
                    $filePath = $allPath . $filename;
                    // 按照原图的比例生成一个最大为150*150的缩略图并保存为封面图像
                    if ($image->thumb(150, 150)->save($filePath)) {
                        unlink($tempFilePath); // 删除临时文件
                    };
                }
            }
        }

    }

    /**
     * [ _updatestatus 通用更新数据处理 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T13:58:22+0800
     * @return   [type]                   [description]
     */
    protected function _updatestatus()
    {
        if (!$this->id) {
            return $this->error('参数错误');
        }

        $controller = $this->app->request->controller(); // 取得控制器名称

        // 管理员时的特殊处理
        //
        switch (strtolower($controller)) {
            case 'manager':
                if ($this->id == 1) {
                    return $this->error('超级管理员不能禁用');
                }
                break;
            case 'ucentermember':
                if ($this->id == 1) {
                    return $this->error('不好意思，你这是用造反么？我是创始用户');
                }
                # code...
                break;
            default:
                # code...
                break;
        }

        // 判断超级管理员
        if ($this->isWithTrashed()) {
            $data = $this->model::withTrashed()->find($this->id);
        } else {
            $data = $this->model->get($this->id);
        }

        $value = $data->getData('status'); // 取得 status 原始数据

        $value = $value ? 0 : 1; // status 数据

        $result = $this->model->where($this->pk, $this->id)->setField('status', $value);

        if ($result) {
            switch (strtolower($controller)) {
                case 'authrule':
                    $this->model->updateCache();
                    break;
                case 'config':
                    $Config = new \app\common\model\Config;
                    $config = $Config->cache_config();
                    break;
                default:
                    # code...
                    break;
            }

            $this->app->hook->listen('action_log', ['record_id' => $this->id]); // 行为日志记录

            return $this->success('操作成功');
        } else {
            return $this->error('操作失败');
            // return $this->model->getError();
        }
    }

    /**
     * [ _del 删除时的数据处理 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T13:56:09+0800
     * @return   [type]                   [description]
     */
    protected function _del()
    {
        // 参数判断
        if (!$this->id) {
            return $this->error('参数错误');
        }

        $controller = strtolower($this->app->request->controller()); // 取得控制器

        // 各种模型下的处理
        switch ($controller) {
            case 'manager':
                if ($this->id == 1) {
                    return $this->error('超级管理员不能进行删除');
                }
                # code...
                break;
            case 'ucentermember':
                if ($this->id == 1) {
                    return $this->error('不好意思，你这是用造反么？我是创始用户');
                }
                # code...
                break;
            default:
                # code...
                break;
        }

        // 管理员的时候执行完全删除操作（在不是开发模型下）
        if ($this->app->session->get('manager_id') == 1 && !$this->app->config('app_debug')) {
            $status = $this->model::destroy($this->id, true); // 删除操作
        } else {
            $status = $this->model::destroy($this->id); // 删除操作（如果模型里引用软删除就是软件删除，如果没有就是直接删除）
        }

        // 成功之后
        if ($status) {
            switch ($controller) {
                case 'manager':
                    model('authGroupAccess')->delDataByUid($this->id);
                    break;
                case 'authgroup':
                    model('authGroupAccess')->delDataByGid($this->id);
                    break;
                case 'authrule':
                    $this->model->updateCache();
                    break;
                default:
                    # code...
                    break;
            }

            // 写入操作用户 id 和 ip
            if ($this->isWithTrashed()) {
                $data = $this->model->withTrashed()->find($this->id);
            } else {
                $data = $this->model->get($this->id);
            }

            if ($data) {
                $data->delete_uid = $this->app->session->get('manager_id');
                $data->delete_ip  = ip2int();
                $data->save();
            }

            Hook::listen('action_log', ['record_id' => $this->id]); // 行为日志记录

            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }

    /**
     * [ hasDeleteTimeField 查询表是否有 delete_time 字段 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T15:36:19+0800
     * @return   boolean                  [description]
     */
    protected function hasDeleteTimeField()
    {
        $bool = false;
        $data = $this->model->find();
        if ($data) {
            $data = $data->toArray();
            foreach ($data as $key => $value) {
                if ($key == 'delete_time') {
                    $bool = true;
                    break;
                }
            }
        }
        return $bool;
    }

    /**
     * [ isWithTrashed 是否需要进行软删除数据查询 ]
     * @author SpringYang <ceroot@163.com>
     * @dateTime 2017-10-31T15:46:09+0800
     * @return   boolean                  [description]
     */
    protected function isWithTrashed()
    {
        $bool = false;
        if ($this->app->session->get('manager_id') == 1 && $this->hasDeleteTimeField()) {
            $bool = true;
        }
        return $bool;
    }

}
