<?php
// +----------------------------------------------------------------------+
// | BWCMS                                                                |
// +----------------------------------------------------------------------+
// | Copyright (c) 2018 http://www.benweng.com All rights reserved.       |
// +----------------------------------------------------------------------+
// | Authors: SpringYang [ceroot@163.com]                                 |
// +----------------------------------------------------------------------+
/**
 *
 * @filename  Widgets.php
 * @authors   SpringYang
 * @email     ceroot@163.com
 * @QQ        525566309
 * @date      2017-10-30 16:15:36
 * @site      http://www.benweng.com
 * @version   $Id$
 */

namespace app\console\widget;

use app\common\controller\Extend;

class Widgets extends Extend
{
    public function operationbar($v = 1, $e = 1, $d = 1, $id = null)
    {
        $type['v']  = $v;
        $type['e']  = $e;
        $type['d']  = $d;
        $type['id'] = $id;
        $this->assign('type', $type);
        return $this->fetch('widget/operationbar');
    }

    public function tabletoolbar($v = 1, $e = 1, $d = 1)
    {
        $type['v'] = $v;
        $type['e'] = $e;
        $type['d'] = $d;
        $this->assign('type', $type);
        return $this->fetch('widget/tabletoolbar');
    }

    public function updatestatus()
    {
        return $this->fetch('widget/updatestatus');
    }

    /**
     * @name  form                    [通用表单]
     * @param string   $type          [表单类型]
     * @param string   $title         [标题]
     * @param string   $name          [字段名称]
     * @param string   $value         [表单内容]
     * @param string   $elementid     [元素 id]
     * @param string   $placeholder   [表单提示内容]
     * @param array    $data          [查询的数据]
     * @param string   $multiple      [选择框多选标识，默认为单选]
     * @param array    $datalist      [单选框、复选框、select列表数据]
     * @param int      $default  [单选默认显示，默认值为1]
     * @param string   $aux           [辅助信息]
     * @param boolean  $inline        [表单元素是否是块元素，默认为1（inline），其它为block]
     * ---------------------------------------------------------
     * @param string   $layverify     [layui表单验证方式，支持多规则验证，用|来分割]
     *                                required（必填项）
     *                                phone（手机号）
     *                                email（邮箱）
     *                                url（网址）
     *                                number（数字）
     *                                date（日期）
     *                                identity（身份证）
     *                                自定义
     *----------------------------------------------------------
     * @return html                   [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use  {:widget('Widgets/text', ['title'=>'标题','name'=>'name 值','value'=>'value 值','elementid'=>'元素 id 值','placeholder'=>'信息提示'])}
     ***********************
     ****  type 类型  ****
     * button  定义可点击的按钮（大多与 JavaScript 使用来启动脚本）
     * checkbox    定义复选框。
     * color   定义拾色器。5
     * date    定义日期字段（带有 calendar 控件）5
     * datetime    定义日期字段（带有 calendar 和 time 控件）5
     * datetime-local  定义日期字段（带有 calendar 和 time 控件）5
     * month   定义日期字段的月（带有 calendar 控件）5
     * week    定义日期字段的周（带有 calendar 控件）5
     * time    定义日期字段的时、分、秒（带有 time 控件）5
     * email   定义用于 e-mail 地址的文本字段5
     * file    定义输入字段和 "浏览..." 按钮，供文件上传
     * hidden  定义隐藏输入字段
     * image   定义图像作为提交按钮
     * number  定义带有 spinner 控件的数字字段5
     * password    定义密码字段。字段中的字符会被遮蔽。
     * radio   定义单选按钮。
     * range   定义带有 slider 控件的数字字段。5
     * reset   定义重置按钮。重置按钮会将所有表单字段重置为初始值。
     * search  定义用于搜索的文本字段。5
     * submit  定义提交按钮。提交按钮向服务器发送数据。
     * tel 定义用于电话号码的文本字段。5
     * text    默认。定义单行输入字段，用户可在其中输入文本。默认是 20 个字符。
     * textarea
     * url 定义用于 URL 的文本字段。5
     */
    public function form($type = 'text', $title = null, $name = null, $value = null, $elementid = null, $placeholder = null, $data = null, $datalist = null, $multiple = false, $default = 1, $layverify = null, $aux = null, $inline = 1)
    {
        // $datalist = [
        //     ['value' => '1', 'title' => '正常'],
        //     ['value' => '0', 'title' => '禁用'],
        // ];
        // dump($datalist);
        $wdata['type']        = $type;
        $wdata['title']       = $title;
        $wdata['name']        = $name;
        $wdata['elementid']   = $elementid;
        $wdata['value']       = $value;
        $wdata['placeholder'] = $placeholder ?? $title;
        // $wdata['tips']        = $tips;
        $wdata['data']      = $data;
        $wdata['datalist']  = $datalist;
        $wdata['layverify'] = $layverify;
        $wdata['aux']       = $aux;
        $wdata['inline']    = $inline;
        $wdata['default']   = $default;
        // dump($wdata);

        switch ($type) {
            case 'text':
                //$type = $type;
                break;
            case 'email':
                $type = 'text';
            case 'mobile':
                $type = 'text';
                break;
            case 'number':
                $type = 'text';
                break;
            case 'tel':
                $type = 'text';
                break;
            case 'url':
                $type = 'text';
                break;
            case 'password':
                unset($wdata['value']);
                break;
            case 'radio':
                //$wdata['default'] = $default;
                break;

            case 'checkbox':
                $wdata['name'] = (count($datalist) == 1) ? $name : $name . '[]';
                break;
            case 'switch':
                $wdata['switch'] = '开启|关闭'; //'ON|OFF
                break;
            case 'select':
                if ($multiple) {
                    $wdata['name'] = $name . '[]';
                }
                $wdata['multiple'] = $multiple;
                break;
            default:
                # code...
                break;
        }

        $template = 'widget/' . $type;

        $this->assign('wdata', $wdata);
        return $this->fetch($template);
    }

    public function test($type = 'text', $data = [])
    {
        $default = [
            'title'       => null,
            'name'        => null,
            'value'       => null,
            'elementid'   => null,
            'placeholder' => null,
            'data'        => null,
            'datalist'    => null,
            'multiple'    => false,
            'default'     => 1,
            'layverify'   => null,
            'aux'         => null,
            'inline'      => 1,
        ];

        $data = array_merge($default, $data);

        return $data['title'];
    }

    /**
     * @name  text                  [通用文本输入框]
     * @param string   $title       [标题]
     * @param string   $name        [表单 name 值]
     * @param string   $value       [表单内容]
     * @param string   $elementid       [元素 id]
     * @param string   $placeholder [提示信息]
     * @return html                 [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use  {:widget('Widgets/text', ['title'=>'标题','name'=>'name 值','value'=>'value 值','elementid'=>'元素 id 值','placeholder'=>'信息提示'])}
     */
    public function text($title = null, $field = 'contnet', $value = null, $elementid = null, $placeholder = null)
    {
        $wdata['title']     = $title;
        $wdata['field']     = $field;
        $wdata['elementid'] = $elementid;
        $wdata['value']     = $value;
        if ($placeholder) {
            $wdata['placeholder'] = $placeholder;
        } else {
            $wdata['placeholder'] = $title;
        }
        $this->assign('wdata', $wdata);
        return $this->fetch('widget/text');
    }

    public function textarea()
    {
        return $this->fetch('widget/textarea');
    }

    public function checkbox()
    {
        return $this->fetch('widget/checkbox');
    }

    /**
     * @name  password              [通用文本输入框]
     * @param string   $title       [标题]
     * @param string   $field        [表单 name 值]
     * @param string   $value       [表单内容]
     * @param string   $elementid       [元素 id]
     * @param string   $placeholder [提示信息]
     * @return html                 [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use {:widget('Widgets/password', ['title'=>'标题','name'=>'name 值','elementid'=>'元素 id 值','placeholder'=>'信息提示'])}
     */
    public function password($title = null, $field = null, $elementid = null, $placeholder = null)
    {
        $wdata['title']       = $title;
        $wdata['field']       = $field;
        $wdata['elementid']   = $elementid;
        $wdata['placeholder'] = $placeholder ?? $title;

        $this->assign('wdata', $wdata);
        return $this->fetch('widget/password');
    }

    public function radio()
    {
        $this->assign('wdata', $wdata);
        return $this->fetch('widget/radio');
    }

    private function _radio($radiotype)
    {
        $radiostyle = null;
        switch ($radiotype) {
            case '10':
                $radiostyle = 'yes-no-cn';
                break;
            case '11':
                $radiostyle = 'yes-no-en';
                break;
            case '20':
                $radiostyle = 'open-close-cn';
                break;
            case '21':
                $radiostyle = 'open-close-en';
                break;
            case '30':
                $radiostyle = 'show-hidden-cn';
                break;
            case '31':
                $radiostyle = 'show-hidden-en';
                break;
            case '40':
                $radiostyle = 'normal-disable-cn';
                break;
            case '41':
                $radiostyle = 'normal-disable-en';
                break;
            case '50':
                $radiostyle = 'normal-disable-cn';
                break;
            case '51':
                $radiostyle = 'normal-disable-cn';
                break;
            default:
                # code...
                break;
        }
        return $radiostyle;
    }

    public function select($title = null, $name = null, $list = null, $current = null)
    {
        $this->assign('wdata', $wdata);
        return $this->fetch('widget/selet');
    }

    /**
     * @name  editorForAdmin        [通用编辑器]
     * @param string   $title       [标题]
     * @param string   $name        [表单 name 值]
     * @param string   $value       [表单内容]
     * @param string   $elementid       [元素 id]
     * @return html                 [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use {:widget('Widgets/editorForAdmin', ['title'=>'标题','name'=>'name值','value'=>'value值'])}
     */
    public function editorForAdmin($title = null, $name = 'contnet', $value = null, $elementid = null)
    {
        $data['type']      = 1;
        $data['title']     = $title;
        $data['name']      = $name;
        $data['elementid'] = $elementid;
        $data['value']     = $value;
        $this->assign('data', $data);
        return $this->fetch('widget/editorForAdmin');
    }

    /**
     * @name  button                [底下提交按钮]
     * @param string   $field       [主键字段名称，默认为id]
     * @param string   $value       [主键字段值]
     * @param string   $buttontext  [按钮显示文字，默认为保存]
     * @return html                 [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use {:widget('Widgets/button', ['field'=>'id','value'=>'value值','buttontext'=>'提交'])}
     */
    public function button($field = 'id', $value = null, $buttontext = '提交')
    {
        $this->assign('field', $field);
        $this->assign('value', $value);
        $this->assign('buttontext', $buttontext);
        return $this->fetch('widget/button');
    }

    /**
     * @name  page                 [底下的分页]
     * @param string   $page       [分页数据]
     * @return html                 [返回 html 代码]
     * @author SpringYang <ceroot@163.com>
     * @use {:widget('Widgets/page', ['page'=>string])}
     */
    public function page($page = null)
    {
        $this->assign('page', $page);
        return $this->fetch('widget/page');
    }

}
