/**
 * 
 * @authors SpringYang (ceroot@163.com)
 * @date    2018-01-09 10:56:16
 * @version $Id$
 */
layui.define('layer', function(exports){
  	var $ = layui.$
  	,layer = layui.layer
  
  	//外部接口
  	,notification = {
	    //……
	    //详见下篇
 	}
  
  	//构造器
  	,Class = function(options){
    	//……
  	};
  
  	//默认配置
  	Class.prototype.config = {
    	//……
  	};
  
  	//核心入口
  	notification.open = function(options){
    	return layer.msg(options.content || '');
  	};

  	notification.open2 = function(options){
	  	var hm = document.createElement("script");
	  	hm.src = "https://hm.baidu.com/hm.js?9d431989a95c98f4e1d5353cadad4487";
	  	var s = document.getElementsByTagName("script")[0]; 
	  	s.parentNode.insertBefore(hm, s);
  	};

	notification.ueditor = function(options){
		// var oHead = document.getElementsByTagName('HEAD').item(0);
		// var oScript= document.createElement("script");
		// var oScript2= document.createElement("script");
		// oScript.type = "text/javascript";
		// oScript.src="/static/libs/ueditor/1.4.3.2/ueditor.config.js";
		// oHead.appendChild( oScript); 

		// oScript2.type = "text/javascript";
		// oScript2.src="/static/libs/ueditor/1.4.3.2/ueditor.all.js";
		// oHead.appendChild( oScript2); 

		var Skip={};
		//获取XMLHttpRequest对象(提供客户端同http服务器通讯的协议)
		Skip.getXmlHttpRequest=function (){ 
			if ( window.XMLHttpRequest ) // 除了IE外的其它浏览器
		 	return new XMLHttpRequest(); 
		 	else if ( window.ActiveXObject ) // IE 
			return new ActiveXObject("MsXml2.XmlHttp"); 
		},
		//导入内容
		Skip.includeJsText = function (rootObject,jsText){ 
		 	if ( rootObject != null ){ 
		 		var oScript = document.createElement( "script" );
		 		oScript.type = "text/javascript"; 
				//oScript.id = sId; 
				//oScript.src = fileUrl; 
				//oScript.defer = true; 
				oScript.text = jsText; 
				rootObject.appendChild(oScript); 
				//alert(oScript.text);
		 	} 
		},
		//导入文件
		Skip.includeJsSrc =function (rootObject, fileUrl){ 
		 	if (rootObject != null){ 
		 		var oScript = document.createElement( "script" ); 
		 		oScript.type = "text/javascript"; 
		 		oScript.src = fileUrl; 
		 		rootObject.appendChild(oScript); 
		 	} 
		},
		//同步加载
		Skip.addJs=function(rootObject, url){ 
		 	var oXmlHttp = Skip.getXmlHttpRequest(); 
		 	oXmlHttp.onreadystatechange = function(){
		 		//其实当在第二次调用导入js时,因为在浏览器当中存在这个*.js文件了,它就不在访问服务器,也就不在执行这个方法了,这个方法也只有设置成异步时才用到
				if (oXmlHttp.readyState == 4 ){ //当执行完成以后(返回了响应)所要执行的
		 			if (oXmlHttp.status == 200 || oXmlHttp.status == 304){ //200有读取对应的url文件,404表示不存在这个文件
		 				Skip.includeJsSrc(rootObject, url); 
		 			}else{ 
		 				alert('XML request error: ' + oXmlHttp.statusText + '(' + oXmlHttp.status + ')'); 
		 			} 
				} 
			} 
			//1.True 表示脚本会在 send() 方法之后继续执行，而不等待来自服务器的响应,并且在open()方法当中有调用到onreadystatechange()这个方法。通过把该参数设置为 "false"，可以省去额外的 onreadystatechange 代码,它表示服务器返回响应后才执行send()后面的方法.
			//2.同步执行oXmlHttp.send()方法后oXmlHttp.responseText有返回对应的内容,而异步还是为空,只有在oXmlHttp.readyState == 4时才有内容,反正同步的在oXmlHttp.send()后的操作就相当于oXmlHttp.readyState == 4下的操作,它相当于只有了这一种状态.
			oXmlHttp.open('GET', url, false); //url为js文件时,ie会自动生成 '<script src="*.js" type="text/javascript"> </scr ipt>',ff不会 
			oXmlHttp.send(null); 
			Skip.includeJsText(rootObject,oXmlHttp.responseText);
		}
		// };
		// var rootObject=document.getElementById("divId");
		var rootObject = document.getElementsByTagName('HEAD').item(0);
		Skip.addJs(rootObject,"/static/libs/ueditor/1.4.3.2/ueditor.config.js")//test.js文件中含有funciotn test(){alert("test");}
		Skip.addJs(rootObject,"/static/libs/ueditor/1.4.3.2/ueditor.all.js")//test.js文件中含有funciotn test(){alert("test");}
		// test();//即使马上调用也不会出错了.

    var ue = UE.getEditor('content',{
        zIndex:898,
        topOffset:48,
        // initialFrameHeight:'500',
        // toolbarTopOffset:50,
        maximumWords:50000
    });

    UE.getEditor('content').addListener('beforefullscreenchange',function(event,isFullScreen){
        if(isFullScreen){
            // alert('全屏');
            $('body').find('.edui-editor').css({'top':0});
        }else{
            // alert('默认');
            $('body').find('.edui-editor').css({'top':48+'px'});
        }
    });
	}

  
  	exports('notification', notification);
});


