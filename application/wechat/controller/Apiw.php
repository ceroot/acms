<?php
/**
 *
 * @authors SpringYang (ceroo@163.com)
 * @date    2018-03-11 13:09:32
 * @version $Id$
 */
namespace app\wechat\controller;

use EasyWeChat\Factory;
use think\Controller;

class Apiw extends Controller
{
    public function index()
    {
        $config = [
            'app_id'        => 'wx3cf0f39249eb0exx',
            'secret'        => 'f1c242f4f28f735d4687abb469072axx',

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log'           => [
                'level' => 'debug',
                'file'  => __DIR__ . '/wechat.log',
            ],
        ];

        $app = Factory::officialAccount($config);

        $response = $app->server->serve();

        // 将响应输出
        // return $response->send(); // Laravel 里请使用：return $response;
        return $response;
    }

    public function ss()
    {
        // 所有的应用服务都通过主入口 EasyWeChat\Factory 类来创建：

// 公众号
        $app = Factory::officialAccount($config);

// 小程序
        $app = Factory::miniProgram($config);

// 开放平台
        $app = Factory::openPlatform($config);

// 企业微信
        $app = Factory::weWork($config);

// 微信支付
        $app = Factory::payment($config);

    }
}
