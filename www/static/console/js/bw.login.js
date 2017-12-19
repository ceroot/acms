/**
 * 
 * @authors SpringYang (ceroot@163.com)
 * @date    2017-01-14 15:01:26
 * @version $Id$
 */

$(function(){
    var storage     = window.localStorage;  // html5 本地存储对象
    var username    = $('input[name="username"]');
    var password    = $('#password');
    var remember    = $('#remember');

    //本地存储数据判断[html5/cookie]
    if(storage){
        if(storage.getItem('username')){
            username.val(storage.getItem('username'));
            password.focus();
            remember.prop('checked',true);
        }else{
            username.focus();
        }
    }else{
        if($.cookie(COOKIE_NAME)){
            username.val($.cookie(COOKIE_NAME));
            password.focus();
            remember.prop('checked',true);
        }else{
            username.focus();
        }
    }

});

layui.use(['form'], function(){
  var form = layui.form
  ,layer = layui.layer;
 
  //自定义验证规则
  form.verify({
    username: function(value){
      if(value.length < 4){
        return '用户名/邮箱至少得5个字符啊';
      }
    }
    ,password: [/(.+){6,12}$/, '密码必须6到12位']
    
  });

  //监听提交
  form.on('submit(demo1)', function(data){
    var loading   = layer.load();
    var username  = $('input[name="username"]');
    var button    = $('button');
    var storage   = window.localStorage;  // html5 本地存储对象
    
    // 本地记住用户名
    if ($('#remember').prop('checked')==true) {
        if(storage){
            storage.setItem('username',username.val());
        }else{
            $.cookie(COOKIE_NAME,username.val(), { path: '/', expires: 15 });
        }
    }else{
        if(storage){
            storage.removeItem('username');
        }else{
            $.cookie(COOKIE_NAME, null, { path: '/' });  //删除cookie
        }
    }
    
    button.prop('disabled',true).text('登录中…');
    // layer.alert(JSON.stringify(data.field), {
    //   title: '最终的提交信息'
    // });
    $.ajax({
        url: window.location,
        type: 'POST',
        dataType: 'json',
        data:data.field,  // data: _form.serialize(),
    })
    .done(function(result) {
        console.log(result);
        if(result.code==1){
            // layer.msg(result.msg);
            layer.close(loading);
            //swal(result.msg, "你点击了按钮！","success");
            // if(getQueryString('backurl')){
            //     var jumpurl  = getQueryString('backurl');
            //     jumpurl = href;

            // }else{
            //     var jumpurl  = result.url;
            // }
            swal({
                title:result.msg,
                text: "正在进行页面跳转……",
                type:"success",
                timer: 2000,
                closeOnConfirm:false,
                showLoaderOnConfirm: true, 
                confirmButtonText:'进入',
            },
            function(){
                layer.load();
                var href = window.location.href
                    ,jumpurl;
                // if(href.indexOf('?backurl=') >= 0 || href.indexOf('backurl/') >= 0){
                if(href.indexOf('backurl=') >= 0){
                    href = href.split('backurl=');
                    jumpurl = href[1];
                    if(!jumpurl){
                        jumpurl = '/console/index/index';
                    }
                }else{
                    jumpurl  = result.url;
                }

                jumpurl = decodeURIComponent(jumpurl);
                console.log(jumpurl);
                window.location.href = jumpurl;
            });
        }else{
            // layer.msg(result.msg,function(){});
            layer.close(loading);
            swal({ 
                  title: '登录失败', 
                  text: result.msg, 
                  timer: 2000, 
                  type:'error',
                  confirmButtonText:'关闭',
                  // showConfirmButton: false 
                });
            button.prop('disabled',false).text('登录');
        }
        if(result.data){
            if(result.data.error_num >= 3){
                if(!$('div').hasClass('captcha-area')){
                    $('.btn-area').before(result.data.verifyhtml);
                }else{
                    changeCode();
                };
            }else{
                //$('.captcha-area').remove();
            }
        }else{
            console.log(1);
        }
    })
    .fail(function(result) {
        layer.close(loading);
        console.log('fail');
        button.prop('disabled',false).text('登录');
    })
    .always(function() {
        //console.log("complete");
    });
    return false;
  });
  
  // 点击切换验证码
  $('body').on('click', '.captcha-area img', function(event) {
      event.preventDefault();
      changeCode();
  });

});

particlesJS('particles-js',{
    "particles": {
        "number": {
            "value": 100,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#ffffff"
        },
        "shape": {
            "type": "circle", // "circle", "edge" or "triangle"
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 5
            },
            // "image": {
            //     "src": "img/github.svg",
            //     "width": 100,
            //     "height": 100
            // }
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 4,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 80,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 100,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 2
        },
        "move": {
            "enable": true,
            "speed": 4,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                //"mode": "grab" //"grab" "bubble" "repulse"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            // "grab": {
            //     "distance": 800,
            //     "line_linked": {
            //         "opacity": 1
            //     }
            // },
            // "bubble": {
            //     "distance": 800,
            //     "size": 80,
            //     "duration": 2,
            //     "opacity": 0.8,
            //     "speed": 3
            // },
            // "repulse": {
            //     "distance": 400,
            //     "duration": 0.4
            // },
            "push": {
                "particles_nb": 12
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});

// 取得时间函数
function genTimestamp(){
    var time = new Date();
    return time.getTime();
}

// 切换验证码函数
function changeCode(){
    var imgsrc = $('.captcha-area img').attr('src');
    $('.captcha-area img').attr('src',imgsrc + '?t='+genTimestamp());
    $('body').find('#verify').val('').focus();
}

// 取得 url 参数
function getQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

