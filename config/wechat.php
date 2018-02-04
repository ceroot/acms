<?php
// +----------------------------------------------------------------------+
// | CYCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  wechat.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2018-01-30 17:52:51
 * @site      http://www.benweng.com
 * @version   $Id$
 */

return [
    'token'          => 'benweng', //填写你设定的token
    'appid'          => 'wx1a10481fbc43aa86', //填写高级调用功能的app id, 请在微信开发模式后台查询
    'appsecret'      => 'd4624c36b6795d1d99dcf0547af5443d', //填写高级调用功能的密钥
    // 'appid'          => 'wx63815c62b3a8bf3e', //2
    // 'appsecret'      => '84ffe3f5ddc205f36618bfac226036d5', //2
    // 'appid'          => 'wxd5e8db24ff394381', //填写高级调用功能的app id, 请在微信开发模式后台查询
    // 'appsecret'      => '8e71a0fba9237e5650ced68a8de4da26', //填写高级调用功能的密钥
    'encodingaeskey' => 'dkYGTNzvKylvMTgY1aK9hNa5aWH43cnlxgTrMr9R3ds', //填写加密用的EncodingAESKey（可选，接口传输选择加密时必需）
    'mch_id'         => '', //微信支付，商户ID（可选）
    'partnerkey'     => '', //微信支付，密钥（可选）
    'ssl_cer'        => '', //微信支付，双向证书（可选，操作退款或打款时必需）
    'ssl_key'        => '', //微信支付，双向证书（可选，操作退款或打款时必需）
    'cachepath'      => '', //设置SDK缓存目录（可选，默认位置在./Wechat/Cache下，请保证写权限）
];

// wx63815c62b3a8bf3e
// 84ffe3f5ddc205f36618bfac226036d5
