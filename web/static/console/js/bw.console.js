/**
 * 
 * @authors SpringYang (ceroot@163.com)
 * @date    2016-04-13 11:44:24
 * @version $Id$
 */

if (typeof jQuery === "undefined") {
  throw new Error("需要引入 jQuery");
}

$.Cy = {};

/* --------------------
 * - Cy Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.Cy.options = {};

var doc      = document;
var storage  = window.localStorage;  // html5 本地存储对象

$(function(){
    'use strict';
    _init();

    $.Cy.layout.activate();

    // document.onkeydown = function(){  
    //     var oEvent = window.event;
    //     // 全屏快捷键 Atl + x
    //     if (oEvent.keyCode == 88 && oEvent.altKey) {
    //         $.Cy.fulWrapper.main();
    //     }

    //     // 侧边栏快捷键
    //     if (oEvent.keyCode == 90 && oEvent.altKey) {
    //         $.Cy.sidebar.fold();
    //     }
    // }

    // 关于服务端url没有#!的处理
    putHash();

    $("#file0").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;
        
        if (objUrl) {
            $("#img0").attr("src", objUrl) ;
        }

        $('.cover-show').show();
    });

    $('body').on('click', '.fileinput-remove-button', function(event) {
        event.preventDefault();
        $('.cover-show').hide();
    });
    
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            //$("#oldcheckpic").val("nopic");
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            //$("#oldcheckpic").val("nopic");
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            //$("#oldcheckpic").val("nopic");
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
});

function _init(){
    'use strict';

    $.Cy.layout  = {
        activate:function(){
            var _this  = this;
            _this.main();
            _this.slimScroll();
            _this.productSidebar();
            _this.logout(); // 退出

            $.Cy.sidebar.init();
            $.Cy.fulWrapper.init();
            $.Cy.layui.init();
            $.Cy.ajax.init();

            $(window,'.bw-wrapper').resize(function(event) {
                _this.slimScroll();
            });
            
        },
        main:function(){
            
        },

        // 滚动条
        slimScroll:function(){
            var _this  = this;
            // 左边菜单滚动条
            var sidebar  = $('body').find('.sidebar');
            sidebar.slimScroll({destroy: true}).height("auto");
            sidebar.slimScroll({
                height: ($(window).height() - $('.bw-header').height() - $('.copyright').height()) + 'px',
                color: 'rgba(0,0,0,0.2)',
                size: '0px',
                // wrapperClass:'sidebarScroll'
            });

            // 二级菜单滚动
            if($(window).width()>768){
                var productSidebar  = $('body').find('.product-sidebar-wrapper');

                productSidebar.slimScroll({destroy: true}).height("auto");
                productSidebar.slimscroll({
                    height: ($(window).height() - $('.bw-header').height()) + 'px',
                    color: 'rgba(0,0,0,0.2)',
                    size: '5px',
                    opacity:0.6,
                    // wrapperClass:'productSidebarScroll'
                });
            }

            // 主体滚动函数
            // _this.contentMainScroll();
        },

        // 主体滚动
        contentMainScroll:function(){
            var contentMain  = $('.content-main');
            var height;
            $('body').hasClass('full-wrapper') ? height  = $(window).height() : height  = $(window).height() - $('.bw-header').height();

            contentMain.slimScroll({destroy: true}).height("auto");
            contentMain.slimscroll({
                // height: ($(window).height() - $('.bw-header').height()) + 'px',
                height: height + 'px',
                color: 'rgba(0,0,0,0.2)',
                size: '10px',
                opacity:0.8,
                alwaysVisible: true,
                // railVisible: true,
                // disableFadeOut:true
                // width: 'auto', //可滚动区域宽度
                // height: '100%', //可滚动区域高度
                // size: '10px', //组件宽度
                // color: '#000', //滚动条颜色
                // position: 'right', //组件位置：left/right
                // distance: '0px', //组件与侧边之间的距离
                // start: 'top', //默认滚动位置：top/bottom
                // opacity: .4, //滚动条透明度
                // alwaysVisible: true, //是否 始终显示组件
                // disableFadeOut: false, //是否 鼠标经过可滚动区域时显示组件，离开时隐藏组件
                // railVisible: true, //是否 显示轨道
                // railColor: '#333', //轨道颜色
                // railOpacity: .2, //轨道透明度
                // railDraggable: true, //是否 滚动条可拖动
                // railClass: 'slimScrollRail', //轨道div类名 
                // barClass: 'slimScrollBar', //滚动条div类名
                // wrapperClass: 'slimScrollDiv', //外包div类名
                // allowPageScroll: true, //是否 使用滚轮到达顶端/底端时，滚动窗口
                // wheelStep: 20, //滚轮滚动量
                // touchScrollStep: 200, //滚动量当用户使用手势
                // borderRadius: '7px', //滚动条圆角
                // railBorderRadius: '7px' //轨道圆角
            });
        },

        // 二级侧边
        productSidebar:function(){
            // 隐藏左第二级侧边
            $('body').on('click', '.second-sidebar-toggle', function(event) {
                event.preventDefault();
                /* Act on the event */
                var mainWrapper  = $('.bw-wrapper');
                var productSidebarControl  = $('.product-sidebar-control i');
                if(mainWrapper.hasClass('product-sidebar-fold')){
                    mainWrapper.removeClass('product-sidebar-fold');
                    // 本地存储数据判断[html5/cookie]
                    storage ? storage.removeItem('productSidebarFold') : $.cookie(productSidebarFold, null, { path: '/' });  //删除cookie
                }else{
                    mainWrapper.addClass('product-sidebar-fold');
                    // 本地存储数据判断[html5/cookie]
                    storage ? storage.setItem('productSidebarFold',1) : $.cookie(productSidebarFold,1, { path: '/', expires: 15 });
                };
            });
        },

        fix:function(){
            console.log(0);
        },
        logout:function(){
            $('body').on('click', '.logout', function(event) {
                event.preventDefault();
                var _href = $(this).attr('href');
                
                swal({ 
                  title: '确定要注销么', 
                  text: '注销之后再登录才能进行操作', 
                  type: 'warning', 
                  confirmButtonText:'注销',
                  cancelButtonText:'关闭',
                  showCancelButton: true, 
                  closeOnConfirm: false, 
                  showLoaderOnConfirm: true, 
                },
                function(){
                    $.post(_href, {}, function(data, textStatus, xhr) {
                        /*optional stuff to do after success */
                        window.location.href = data.url;
                    });
                });
                // return false;
                /* Act on the event */
            });;
        }
    };

    $.Cy.sidebar  = {
        init:function(){
            var _this  = this;

            _this.main();
            _this.click();
            _this.hover();

        },
        main:function(){
            var _this  = this;
            // 侧边栏折叠
            $('body').on('click', '.bw-sidebar-toggle', function(event) {
                event.preventDefault();
                _this.fold();
            });

            // 屏幕大小判断
            if(getWindowSize().x<1366){
                $.get('/console/index/getcollapsed',{},function(data){
                    if(data==1){
                        
                    }else{
                        $.post('/console/index/setcollapsed',{collapsed:1});
                        if($('body').hasClass('sidebar-expanded')){
                            $('body').removeClass('sidebar-expanded').addClass('sidebar-collapsed');
                        }
                    }
                });

            };

            $('body').on('mouseenter', '.sidebar-tooltip', function(event) {
                event.preventDefault();
                /* Act on the event */
                var dataTooltip  = $(this).prop('data-tooltip');
                $('.sidebar>ul>li').eq(dataTooltip).find('dl>dt>a').addClass('current');
                $('.sidebar>ul>li').eq(dataTooltip).siblings().find('dl>dt>a').removeClass('current');
            });

            $('body').on('mouseleave', '.bw-sidebar', function(event) {
                event.preventDefault();
                /* Act on the event */
                $('body').find('.sidebar-tooltip').fadeOut('normal',function(){
                    $('body').find('.sidebar-tooltip').remove();
                })
                $('.sidebar>ul>li').find('dl>dt>a').removeClass('current');
            });
        },
        click:function(){
            // 主菜单点击事件
            $('body').on('click', '.sidebar ul>li>dl>dt>a', function(event) {
                /* Act on the event */
                var _self  = $(this);
                var _li    = _self.closest('li');

                if(!$('body').hasClass('sidebar-collapsed')){
                    if(_li.find('dd').length>0){
                        if(_li.hasClass('active')){
                            _li.find('dd').slideUp('normal',function(){
                                _li.removeClass('active');
                            });
                        }else{
                            _li.addClass('active').find('dd').slideDown();
                            _li.siblings().find('dd').slideUp('normal',function(){
                                _li.siblings().removeClass('active');
                            });
                        }
                        return false;
                    }
                }
            });
        },
        hover:function(){
            // 主菜单鼠标移上去
            $('body').on('mouseenter', '.sidebar ul>li', function(event) {
                event.preventDefault();
                /* Act on the event */
                if($('body').hasClass('sidebar-collapsed')){
                    var _self      = $(this);
                    var offsetY    = _self.offset().top;
                    var index      = _self.index();
                    var dlHtml;

                    $('.sidebar>li>dl>dt').find('a').removeClass('current');

                    if($('body').find('.sidebar-tooltip').length==0){
                        var tooltipHtml  = '<div class="sidebar-tooltip" data-tooltip="0"></div>';
                        $('.bw-sidebar').append(tooltipHtml);
                    }

                    if($('body').find('.sidebar-tooltip').length>0){
                        $('body').find('.sidebar-tooltip').hide().fadeIn(150).css({'top':offsetY}).prop('data-tooltip',index);
                        if(_self.find('dl').length>0){
                            dlHtml  = _self.find('dl').prop('outerHTML');
                            $('body').find('.sidebar-tooltip').html(dlHtml);
                        }
                    }

                    if($('body').find('.sidebar-tooltip dd').length>0){
                        $('body').find('.sidebar-tooltip dt').addClass('bbrr-no');
                    }else{
                        $('body').find('.sidebar-tooltip dt').removeClass('bbrr-no');
                    }

                }
            });
        },
        fold:function(){
            // 侧边栏折叠
            if($('body').hasClass('sidebar-expanded')){
                $('body').removeClass('sidebar-expanded').addClass('sidebar-collapsed');
                $.post('/console/index/setcollapsed',{collapsed:1});
                // 本地存储数据判断[html5/cookie]
                storage ? storage.setItem('sidebarFold',1) : $.cookie(sidebarFold,1, { path: '/', expires: 15 });
            }else{
                $('body').removeClass('sidebar-collapsed').addClass('sidebar-expanded');
                $.post('/console/index/setcollapsed',{collapsed:0});
                // 本地存储数据判断[html5/cookie]
                storage ? storage.removeItem('sidebarFold') : $.cookie(sidebarFold, null, { path: '/' });  //删除cookie
            };
        }
        
    };

    // full wrapper
    $.Cy.fulWrapper  = {
        init:function(){
            var _this  = this;
            $('body').on('click', '.full-control', function(event) {
               event.preventDefault();
               _this.main();
            });
        },
        main:function(){
            $('body').hasClass('full-wrapper') ? $('body').removeClass('full-wrapper') : $('body').addClass('full-wrapper');
            // 主体滚动函数
            //$.Cy.layout.contentMainScroll();
        }
    };
  
    // layui
    $.Cy.layui = {
        init:function(){
            var _this = this;

            _this.table();

            layui.use(['layer','element','form'], function(){
                var element = layui.element;
                var form = layui.form;
                var layer = layui.layer;

                element.init();
                form.render();

                //监听指定开关
                form.on('switch(switch)', function(data){
                    console.log(data);
                    var _this = $(this);
                    var _hiddenInput = _this.siblings('input[type="hidden"]'); // 之所以不使用本身，是因为本身是checkbox，当没有选择的时候就无法取得value数据

                    this.checked ? _hiddenInput.val(1) : _hiddenInput.val(0);
                });

                $('a[data-event]').on('click',this,function(e){
                    var _this = $(this);
                    var _event = _this.data('event');
                    console.log(_event);
                    if(_event){
                        tableOperation[_event] ? tableOperation[_event].call(this) : '';
                    }
                    return false;
                    
                });

              
            });
        },
        table:function(){  // 统一表格加载
            layui.use(['table','laypage', 'layer', 'form'], function(){
                var table = layui.table
                    ,laypage = layui.laypage
                    ,layer = layui.layer
                    ,form = layui.form;
                //方法级渲染
                // var cols = new Array();
                // var cols = $('#cols').text();
                // cols = eval('(' + cols + ')');
                // console.log(cols);
                var elem_id = '#table_list'
                    ,url = $(elem_id).data('url')
                    ,cols = new Array();
                // 取得元素
                $(elem_id).find('thead>tr>th').each(function(index, el) {
                    var tmp = $(this).attr('lay-data');
                    tmp = eval('(' + tmp + ')');
                    cols.push(tmp);
                });
                
                table.init('demo', {
                    height: 315 //设置高度
                    //支持所有基础参数
                }); 
                // console.log(cols);
                table.render({
                    elem: elem_id
                    ,url: url
                    //,method: 'post' //如果无需自定义HTTP类型，可不加该参数
                    //,request: {} //如果无需自定义请求参数，可不加该参数
                    //,response: {} //如果无需自定义数据响应名称，可不加该参数
                    //,limits: [30,60,90,150,300]
                    //,limit: 60 //默认采用60
                    //,loading: true
                    ,cols: [cols]
                    ,page: true
                    // ,page: { //详细参数可参考 laypage 组件文档
                    //     layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //     //,curr: 5 //设定初始在第 5 页
                    //     ,groups: 1 //只显示 1 个连续页码
                    //     ,first: false //不显示首页
                    //     ,last: false //不显示尾页
                      
                    // }
                    //,width: 1000
                    ,height: 'full-245'
                    //,skin: 'line' //行边框风格
                    ,even: true //开启隔行背景
                    ,size:'sm'
                    ,id:elem_id
                    //,initSort: {
                        //field: 'id' //排序字段，对应 cols 设定的各字段名
                        //,type: 'desc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                    //}
                    ,response: {
                        statusCode:1 // 成功代码，layui 默认为 0
                        ,countName:'wait' // 使用等待时间作为总条数
                    }
                    ,done: function(res, curr, count){
                        //如果是异步请求数据方式，res即为你接口返回的信息。
                        //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、curr为当前页码、count为数据总长度
                        console.log(res);
                        
                        //得到当前页码
                        console.log(curr); 
                        
                        //得到数据总量
                        console.log(count);
                        layer.closeAll('loading');
                    }
                });

                var active = {
                    selectAll: function(){ // 全选
                        
                        var checkStatus = table.checkStatus(elem_id);
                        console.log(table);
                        // var data = checkStatus.data;
                        // var data = $('input[lay-filter="layTableAllChoose"]');
                        // $('input[lay-filter="layTableAllChoose"]').click();
                        
                        $('input[name="layTableCheckbox"]').prop('checked',true);
                        $(this).attr('data-type','selectSancel').text('取消');
                        form.render('checkbox');

                        // 
                    },
                    selectSancel: function(){ // 取消选择

                        $('input[name="layTableCheckbox"]').prop('checked','');
                        _this.attr('data-type','selectAll').text('全选');

                        form.render('checkbox');
                    },
                    getCheckData: function(){
                        var checkStatus = table.checkStatus(elem_id)
                            ,data = checkStatus.data;
                        if(data.length>0){
                            layer.alert(JSON.stringify(data));
                        }else{
                            layer.msg('没有选择');
                        }
                    }
                    ,getCheckLength: function(){
                        var checkStatus = table.checkStatus(elem_id)
                            ,data = checkStatus.data;
                        layer.msg('选中了：'+ data.length + ' 个');
                    }
                    ,isAll: function(){
                        var checkStatus = table.checkStatus(elem_id);
                        layer.msg(checkStatus.isAll ? '全选': '未全选')
                    }
                    ,search: function(){  // 查询
                        var search_area = $('.search-area')
                            ,where = new Object();
                        where['search'] = true;
                        search_area.find('input').each(function(index, el) {
                            var _self = $(this)
                                ,_name = _self.attr('name')
                                ,_value = _self.val();
                          
                            where[_name] = _value;
                            var _like = _self.data('like'); // 模糊查询标记，目前只能有一个模糊查询元素
                            if(_like){
                              where['like'] = _name;
                            }
                        });

                        console.log(where);
                      
                        var loading = layer.load();
                        table.reload(elem_id, {
                            where: where
                        });
                    }
                    // 显示全部
                    ,allShow:function(){
                        var loading = layer.load();
                        table.reload(elem_id,{
                            where: {
                                search:null
                            }
                        });
                    }
                    ,parseTable: function(){
                        table.init('parse-table-demo');
                    }
                };
              
                $('.search-area .layui-btn').on('click', function(){
                    var type = $(this).data('type');

                    active[type] ? active[type].call(this) : '';
                });
                $('.demoTable .layui-btn').on('click', function(){
                    var type = $(this).attr('data-type');
                    
                    active[type] ? active[type].call(this) : '';
                });

                
                //监听工具条
                table.on('tool('+ elem_id +')', function(obj){
                    var _this = $(this);
                    var _href = _this.attr('href');
                    var _event = obj.event;

                    obj.data.url = _href; // 把 href 添加到对象
                    
                    if(_event){
                        tableOperation[_event] ? tableOperation[_event].call(obj) : '';
                    }

                });

                // 监听复选框选择
                table.on('checkbox('+ elem_id +')', function(obj){
                    var checkStatus = table.checkStatus(elem_id);
                    var select_all = $('body').find('button.select-all');

                    if(obj.type == 'one' || obj.type == 'all'){
                        if(checkStatus.data.length>0){
                            // select_all.data('type','selectSancel').text('取消');
                            select_all.attr('data-type','selectSancel').text('取消');
                        }else{
                            // select_all.data('type','selectAll').text('取消');
                            select_all.attr('data-type','selectAll').text('全选');
                        }
                    }

                  //console.log(obj.checked); //当前是否选中状态
                  //console.log(obj.data); //选中行的相关数据
                  //console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
                });


                //监听正常禁用开关
                form.on('switch(updatestatus)', function(data){
                    var _this = $(this);
                    var _href = _this.data('href');
                    var loading = layer.load();

                    if(!_href){
                        layer.msg('请设置URL参数');
                    }

                    $.post(_href, {}, function(result, textStatus, xhr) {
                        layer.msg(result.msg);
                        console.log(result);
                        if(result.code==0){
                            // _this.trigger('click');
                            // form.render('checkbox');

                            var _switch = _this.siblings('.layui-form-switch');
                            if(data.elem.checked){
                                _this.prop('checked',false);
                                _switch.removeClass('layui-form-onswitch');
                                _switch.find('em').text('禁用');
                            }else{
                                _this.prop('checked',true);
                                _switch.addClass('layui-form-onswitch');
                                _switch.find('em').text('正常');
                            }
                        }
                        layer.close(loading);
                    });

                  //console.log(data.elem); //得到checkbox原始DOM对象
                  //console.log(data.elem.checked); //开关是否开启，true或者false
                  //console.log(data.value); //开关value值，也可以通过data.elem.value得到
                  //console.log(data.othis); //得到美化后的DOM对象
                }); 

                form.on('checkbox(layTableAllChooseTest)', function(data){
                    console.log(data);
                    var child = $(data.elem).parents('.layui-table-view').find('.layui-table-body table.layui-table tbody input[type="checkbox"]');
                    console.log(child);
                    child.each(function(index, item){
                        item.checked = data.elem.checked;
                    });
                });
            });
        }
    };

    // ajax 提交
    $.Cy.ajax  = {
        init:function(){
            var _this  = this;
            _this.a_ajax();
            _this.form_ajax();
        },
        maim:function(){},
        a_ajax:function(){
            // a 标签 ajax 提交，成功之后刷新页面或者跳转到新的页面
            // 使用方法：直接在 a 标签添加 a_ajax class
            // 参数：
            // data-layer-msg：显示提示信息，默认为[操作]
            // data-layer-okbtn：提交按钮文字，默认为[提交]
            // data-layer-cancelbtn：取消按钮文字，默认为[取消]
            // data-layer-confirm: 是否弹出提交提示，默认为[false]不弹出
            var _this = this;
            var a_ajax  = 'cy-ajax';
            if ($('body').find('a.'+a_ajax).length) {
                //Wind.use('layer', function () {
                    $('body').on('click','a.'+a_ajax, function (e) {
                        e.preventDefault();
                        var $_self   = $(this),
                            $_href   = $_self.prop('href'),
                            // $_msg   = $_self.data('msg');
                            $_msg    = $_self.attr('data-layer-msg') ? $_self.attr('data-layer-msg') : '操作',
                            $_ok_btn_text      = $_self.attr('data-layer-okbtn') ? $_self.attr('data-layer-okbtn') : '提交',
                            $_cancel_btn_text  = $_self.attr('data-layer-cancelbtn') ? $_self.attr('data-layer-cancelbtn') : '取消',
                            $_confirm          = $_self.attr('data-layer-confirm')  ? $_self.attr('data-layer-confirm') : false;

                        if($_self.hasClass('disabled')){
                            return false;
                        }
                        if($_confirm){
                            layer.confirm('确定要'+$_msg+'吗？', {
                                icon: 7,
                                btn: [$_ok_btn_text,$_cancel_btn_text], //按钮
                                shadeClose:true,
                            }, function(){
                                var loading = layer.load();
                                $_self.addClass('disabled');
                                _this.a_ajax_json($_self,$_href,$_msg,loading);
                            }, function(index){
                                layer.close(index);
                            });
                        }else{
                            var loading = layer.load();
                            $_self.addClass('disabled');
                            _this.a_ajax_json($_self,$_href,$_msg,loading);
                        }
                    });
                //});
            }
        },
        a_ajax_json:function($_self,$_href,$_msg,loading){
            $.getJSON($_href).done(function(data){
                console.log(data);
                if(data.code){
                    layer.msg(data.msg);
                    // alert(1);
                    layer.closeAll('loading');
                    layer.msg(
                        $_msg+'成功，页面正在进行页面跳转……',
                        {
                            icon: 1,
                            time:800,
                            shift:0,
                        },
                        function(){
                            reloadPage(window);
                        });
                }else{
                    // alert(0);
                    layer.msg(data.msg,{icon:2});
                    layer.closeAll('loading');
                }
            });
        },
        form_ajax:function(){
            layui.use(['form'], function(){
                var form = layui.form
                ,layer = layui.layer;
                
                //监听提交
                form.on('submit(bw-submit)', function(data){
                    
                    console.log(data.field);
                    // layer.alert(JSON.stringify(data.field), {
                    //   title: '最终的提交信息'
                    // });
                    
                    var _self = $(this)
                    ,_btn_text;
    
                    $.ajax({
                        url:_self.closest('form').attr('action') ? _self.closest('form').attr('action') : window.location,
                        type: 'POST',
                        dataType: 'json',
                        data: data.field,
                        beforeSend:function(){
                            layer.load();
                            _btn_text = _self.find('span').text();
                            _self.find('i').hide();
                            _self.prop('disabled', true).addClass('disabled').find('span').text(_btn_text + '中...');
                        }
                    })
                    .done(function(result) {
                        console.log(result);
                        // return false;
                        // layer.alert(JSON.stringify(result), {
                        //   title: '返回信息'
                        // });
                        if(result.code){
                            //layer.msg(result.msg, {time: 5000, icon:6});
                            layer.msg(result.msg,{time:500,shift:0, icon:6},function(){
                               if(result.url){
                                    //window.location.href = result.url;
                                } 
                            });
                        }else{
                            layer.msg(result.msg,{icon:6});
                        }
                        console.log("success");
                    })
                    .fail(function(result) {
                        console.log("error");
                    })
                    .always(function(result) {
                        console.log("complete");
                        layer.closeAll('loading');
                        _btn_text = _self.find('span').text();
                        _self.find('i').show();
                        _self.prop('disabled',false).removeClass('disabled').find('span').text(_btn_text.replace('中...', ''));
                    });
                    
                    return false;
                });

            });
        },
        
    };

}


/**
 * reloadPage       [重新刷新页面，使用location.reload()有可能导致重新提交]
 */
function reloadPage(win)
{
    var location = win.location;
    location.href = location.pathname + location.search;
}

/**
 * getWindowSize          [getWindexSize Fun]
 * 取值方法
 * 取得宽：getWindowSize().x;
 * 取得高：getWindowSize().y;
 * @return     int
 */
function getWindowSize()
{
    var client = {x:0,y:0};
    if(typeof document.compatMode != 'undefined' && document.compatMode == 'CSS1Compat') {
        client.x = document.documentElement.clientWidth;
        client.y = document.documentElement.clientHeight;
    } else if(typeof document.body != 'undefined' && (document.body.scrollLeft || document.body.scrollTop)) {
        client.x = document.body.clientWidth;
        client.y = document.body.clientHeight;
    }
    return client;
}

/**
 * getQueryString           [取得 url 参数]
 *
 * @param   string  name    参数变量
 * @return  string 
 */
function getQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

/**
 * genTimestamp     [取得时间函数]
 * @return     int  [时间截]
 */
function genTimestamp()
{
    var time = new Date();
    return time.getTime();
}

/**
 * getCookie   [取得Cookie值]
 * @param      string  name    The name
 * @return     string  Cookie.
 */
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg)){
        return unescape(arr[2]);
    }else{
        return null;
    }
}

/**
 * putHash   [关于服务端url没有#!的处理]
 * @param      number curr
 */
function putHash(obj=null)
{
    var _hash = location.hash;
   
    if(_hash){
        var curr,limit,loading,
            logoutelement = $('body').find('.logout'),
            _hashEle = '#!page=',
            _href = logoutelement.prop('href'),
            _url = window.location.href;

        _href = _href.split('?backurl=');
        
        _url = _url.split('#!page=');
        _url = _url[0];

        // if(curr == null){
        //     curr = _hash.split('#!page=');
        //     curr = curr[1];
        // }

        if(obj==null){
            console.log(0);
            curr = _hash.split('#!page=');
            curr = curr[1];
        }else{
            console.log(1);
            curr = obj.curr;
            limit = obj.limit;
        }

        _href = _href[0] + '?backurl=' + _url + '#!page=' + curr;
        
        logoutelement.prop('href',_href);  // 改变退出 url
        
        loading = layer.load();

        $.ajax({
            url: window.location.href,
            // url:'http://192.168.1.10:88/console/action_log/hash',
            type: 'PUT',
            dataType: 'json',
            data: {'hash': '#!page=' + curr,'page':curr,'limit':limit},
        })
        .done(function(result) {
            var editUrl = $('body').find('table.table > thead > tr > td.editArea').data('url');
            var newEditUrl = new Array();

            editUrl = editUrl.split('|');
            for(var l=0;l<editUrl.length;l++){
                var tmp = editUrl[l];
                tmp = tmp.split(':');

                var r1 = new Array();
                r1['title'] = tmp[0];
                r1['url'] = tmp[1];
                newEditUrl[l] = r1;
            }

            var _name = new Array();
            $('body').find('table.table > thead > tr > td').each(function(index, el) {
                _name[index] = $(this).data('name');
            });
            var html = '';

            for (var i=0;i<result.length;i++)
            {
                html += '<tr>';
                var nResult = result[i];
                if(_name.length >= 1){
                    for(var m=0;m<_name.length;m++){

                        if(_name[m] == 'editid'){
                            html += '<td align="center">';
                            for(var j=0;j<newEditUrl.length;j++){
                                var _url = newEditUrl[j]['url'];
                                var _title = newEditUrl[j]['title'];

                                html += '<a href="' + _url + '?id=' + nResult['editid'] + '">' + _title + '</a>&nbsp;&nbsp;';
                            }
                            html += '</tr>';
                        }else{
                            html += '<td>' + nResult[_name[m]] + '</td>';
                        }
                    }
                }else{
                    for(var tmp in nResult){
                        if(tmp == 'editid'){
                            html += '<td>';
                            for(var j=0;j<newEditUrl.length;j++){
                                var _url = newEditUrl[j]['url'];
                                var _title = newEditUrl[j]['title'];

                                html += '<a href="' + _url + '?id=' + nResult['editid'] + '">' + _title + '</a> ';
                            }
                            html += '</tr>';
                        }else{
                            html += '<td>' + nResult[tmp] + '</td>';
                        }
                    }
                }

                html += '</tr>';
                $('body').find('.table > tbody').html(html);
                
            }

            console.log(html);
            layer.closeAll();
        })
        .fail(function() {
            //console.log("error");
        })
        .always(function() {
            //console.log("complete");
        });
        
    }
}

var tableOperation = {
    detail:function(){
        var _href;
        var loading = layer.load();
        (this.data == undefined) ? _href = this.href : _href = this.data.url;

        if(!_href){
            layer.msg('请设置URL参数'); return false;
        }

        $.post(_href, {}, function(result, textStatus, xhr) {
            /*optional stuff to do after success */
            var _reg = /<div class="details-content[^>]*>([\s\S]*?)<\/div>/;
            var _content = result.match(_reg);

            if(_content){
                _content = _content[0];
            }else{
                _content = '<h2 style="text-align:center">获取数据有误</h2>';
            }

            layer.open({
                title:'查看详情',
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                area: ['700px', '300px'], //宽高
                content: _content
            });
            layer.close(loading);
        });
    },

    add:function(){    
        var _event = 'edit';
        tableOperation[_event] ? tableOperation[_event].call(this) : '';
    },

    edit:function(){
        var _href;
        var loading = layer.load();
        (this.data == undefined) ? _href = this.href : _href = this.data.url;
        
        if(!_href){
            layer.msg('请设置URL参数'); return false;
        }

        $.get(_href, {}, function(result, textStatus, xhr) {
            var _reg = /<form action="[^>]*>([\s\S]*?)<\/form>/;
            var _content = result.match(_reg);
            // alert(_content[0]);
            var index = layer.open({
                title:'编辑内容',
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                //area: ['800px', '500px'], //宽高
                content: '<div class="edit-content">' + _content[0] + '</div>',
                maxmin: true,
                end:function(){

                }
            });

            // 再次运行 layui 之后，相关组件才有作用
            layui.use(['form','element'], function(){
                var form = layui.form;
                var element = layui.element;

                form.render();
                element.init();
            });
            layer.full(index);  // 全屏
            layer.close(loading);
        });

    },
    del:function(){
        var _obj = this;
        var _href;

        (_obj.data == undefined) ? _href = this.href : _href = _obj.data.url;

        if(!_href){
            layer.msg('请设置URL参数'); return false;
        }

        layer.confirm('真的删除行么', function(index){
            var loading = layer.load();
            $.ajax({
                url: _href,
                type: 'DELETE',
                dataType: 'json',
                data: {},
            })
            .done(function(result) {
                console.log(result);
                if(result.code){
                    // 删除行
                    if(_obj.data != undefined){
                       _obj.del(); 
                    }else{
                        window.location.reload();
                    }
                    
                    layer.msg(result.msg,{icon:6});
                }else{
                    layer.msg(result.msg);
                }
                layer.close(loading);
                layer.close(index);
            })
          
        });
    },
    updatestatus:function(){        
        var _obj = this;
        var _this = $(this);
        var _href = _obj.href;
        var loading = layer.load();

        $.post(_href, {}, function(data, textStatus, xhr) {
            if(data.code){
                var _text = _this.text();
                (_text == '正常') ? _text = '禁用' : _text = '正常';
                _this.text(_text);
                layer.msg(data.msg);
            }else{
                layer.msg(data.msg);
            }
            layer.close(loading);
        });
        
    }
};

