<?php
namespace app\console\controller;

use app\console\controller\Base;
use think\Db;
use think\facade\App;

class Index extends Base
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @Author    Hybrid
     * @DateTime  2017-10-20
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function index()
    {
        $this->assign('info', $this->serverInfo());
        $this->assign('extensionsList', $this->extensionsList());

        $this->assign('articleCount', App::model('Article')->count());
        $this->assign('userCount', App::model('UcenterMember')->count());
        $this->assign('actionCount', App::model('ActionLog')->count());

        return $this->menusView();

    }

    public function hello()
    {
        $value = '<a href="#">assign</a>';
        $this->assign('name', $value);

        return $this->menusView();
    }

    public function copyright()
    {
        $this->assign('info', $this->serverInfo());
        $this->assign('extensionsList', $this->extensionsList());
        return $this->menusView();
    }

    private function serverInfo()
    {
        $request      = request();
        $mysqlVersion = Db::query('select version() as version');
        return [
            'ThinkPHP版本'           => 'ThinkPHP ' . App::version(),
            'CMS信息'                => '作者 : <a class="text-primary" target="new" href="https://www.benweng.com">SpingYang</a> , GIT : <a class="text-primary" target="new" href="https://github.com/">待开放</a>。',
            'CMS版本'                => config('system.version'),
            '操作系统'                 => PHP_OS,
            '主机名信息'                => $request->server('SERVER_NAME') . ' (' . $request->server('SERVER_ADDR') . ':' . $request->server('SERVER_PORT') . ')',
            '运行环境'                 => $request->server('SERVER_SOFTWARE'),
            'PHP版本'                => PHP_VERSION,
            'PHP运行方式'              => php_sapi_name(),
            //'程序目录'                 => WEB_PATH,
            'MYSQL版本'              => 'MYSQL ' . $mysqlVersion[0]['version'],
            '上传限制'                 => ini_get('upload_max_filesize'),
            'POST限制'               => ini_get('post_max_size'),
            '最大内存'                 => ini_get('memory_limit'),
            '执行时间限制'               => ini_get('max_execution_time') . "秒",
            '内存使用'                 => $this->formatBytes(@memory_get_usage()),
            '磁盘使用'                 => $this->formatBytes(@disk_free_space(".")) . '/' . $this->formatBytes(@disk_total_space(".")),
            'display_errors'       => ini_get("display_errors") == "1" ? '√' : '×',
            'register_globals'     => get_cfg_var("register_globals") == "1" ? '√' : '×',
            'magic_quotes_gpc'     => (1 === get_magic_quotes_gpc()) ? '√' : '×',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? '√' : '×',
            // '扩展列表'                 => $this->extensionsList(),

        ];
    }

    // 扩展列表
    private function extensionsList()
    {
        $extensionsList = get_loaded_extensions();
        return implode(' , ', $extensionsList);
    }

    /**
     * [get_mysql_version 数据库版本]
     * @return [type] [description]
     */
    private function get_mysql_version()
    {
        // $user      = db();
        // $pdo       = new PDO("mysql:host=127.0.0.1;dbname=think5", "root", "root");
        $con       = mysql_connect('127.0.0.1', 'root', 'root');
        $mysqlinfo = mysql_get_server_info($con);
        // $res = mysql_query("select VERSION()");
        // $row = mysql_fetch_row($res);
        return $mysqlinfo;
    }

    /**
     * 文件大小格式化
     *
     * @param number $size
     * @param string $delimiter
     * @return string
     */
    private function formatBytes($size, $delimiter = '')
    {
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
            'PB',
        ];
        for ($i = 0; $size >= 1024 && $i < 5; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . $delimiter . $units[$i];
    }

    public function setcollapsed()
    {
        $collapsed = $this->app->request->param('collapsed');
        if ($collapsed == 1 || $collapsed == 0) {
            if ($collapsed == '1') {
                $this->app->session->set('collapsed', $collapsed);
            } else {
                $this->app->session->set('collapsed', null);
            }
        }
    }

    public function getcollapsed()
    {
        if ($this->app->session->has('collapsed')) {
            return $this->app->session->get('collapsed');
        } else {
            return 0;
        }
    }

    public function setsmscscreen()
    {
        $smscreen = $this->app->request->param('screen');
        if ($smscreen == 1 || $smscreen == 0) {
            if ($smscreen == '1') {
                $this->app->session->set('screen', $smscreen);
            } else {
                $this->app->session->set('screen', null);
            }
        }
    }

    public function getsmscscreen()
    {
        if ($this->app->session->has('screen')) {
            return $this->app->session->get('screen');
        } else {
            return 0;
        }
    }
}
