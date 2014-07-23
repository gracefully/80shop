// JavaScript Document
net = new Object();
net.READY_STATE_UNINITIALIZED = 0;
net.READY_STATE_LOADING = 1;
net.READY_STATE_LOADED = 2;
net.READY_STATE_INTERACTIVE = 3;
net.READY_STATE_COMPLETE = 4;

net.ContentLoader = function(url, onload, method, params,onerror, contentType) {
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror: this.defaultError;
	this.loadXMLDoc(url, method, params, contentType);
}

net.ContentLoader.prototype = {
	onReadyState: function() {
		var req = this.req;
		var ready = req.readyState;
		if (ready == net.READY_STATE_COMPLETE) {
			var httpStatus = req.status;
			if (httpStatus == 200 || httpStatus == 0) this.onload.call(this);
			else this.onerror.call(this);
		}
	},
	defaultError: function() {
		//alert("error in fetching data!! readyState==" + this.req.readyState + "\n\nstatus=" + this.req.status + " \n\nheaders" + this.req.getAllResponseHeaders());
	}
}

net.ContentLoader.prototype.loadXMLDoc = function(url, method, params, contentType) {
	if (!method) //如果没有传入method 参数值，则默认为GET
	{
		method = "GET";
	}
	if (!contentType && method == "POST") {
		contentType = "application/x-www-form-urlencoded;";
	}

	if (window.XMLHttpRequest) {
		this.req = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		this.req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (this.req) {

		try {
			var loader = this;
			this.req.onreadystatechange = function() {
				loader.onReadyState.call(loader);
			}
			this.req.open(method, url, true);
			//POST方法需要设置的属性
			if (contentType) {
				this.req.setRequestHeader("Content-Type", contentType);
			}
			this.req.send(params);

		} catch(err) {
			this.onerror.call(this);
		}
	}
}

function getMessage(){
	//alert(this.req.responseText);  //简单的输出返回结果的字符串形式
	//alert(this.req.responseXML);   //XML形式，后面就根据你的需要解析这个XML了
}

function getType(o) {
    var _t;
    return ((_t = typeof(o)) == "object" ? o == null && "null" || Object.prototype.toString.call(o).slice(8, -1) : _t).toLowerCase();
}
function extend(destination, source) {
    for (var p in source) {
        if (getType(source[p]) == "array" || getType(source[p]) == "object") {
            destination[p] = getType(source[p]) == "array" ? [] : {};
            arguments.callee(destination[p], source[p]);
        } else {
            destination[p] = source[p];
        }
    }
}

function arrToParam(array){
	var arr=new Array();
	extend(arr,array);
	var param='';
	var k;
    for(k in arr){
		if(arr[k]!=''){
        	arr[k]=encodeURIComponent(arr[k]);
        	if(param!=''){
            	param+='&'+k+'='+arr[k];
            }
		    else{
            	param+=k+'='+arr[k];
            }
		}
	}
	return param;
}

function ErrorLog(method,error_response){
	if(ERRORLOG==1){
    	var errorParame=new Array();
    	errorParame['method']=method;
    	errorParame['code']=error_response.code;
    	errorParame['msg']=error_response.msg;
    	errorParame['url']=document.URL;
		url="comm/jssdk.error.php?"+arrToParam(errorParame);
		js_send(url,1);
    }
}

function js_send(url){
	url=SITEURL+url+'&check='+CHECKCODE;
    var type=arguments[1];
    var method=arguments[2];
    if(type==1){
    	if(method=='POST'){
        	var a=url.split('?');
        	new net.ContentLoader(url,getMessage,'POST',a[1]);
        }
        else{
        	new net.ContentLoader(url,getMessage);
        }
    }
    else{
    	document.write('<s'+'cript src="'+url+'"></script>');
    }
}

function json2str(o) {
	var arr = [];
	var fmt = function(s) {
		if (typeof s == 'object' && s != null) return json2str(s);
		return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
	}
	for (var i in o) arr.push("'" + i + "':" + fmt(o[i]));
	return '{' + arr.join(',') + '}';
}

function getCacheurl(method,parame){
	var temp=new Array();
    switch(method){
    	case 'taobao.taobaoke.widget.items.convert':
        	temp['method']='taobao.taobaoke.widget.items.convert';
            temp['fields']=parame['fields'];
            temp['num_iids']=parame['num_iids'];
        break;
        
        case 'taobao.taobaoke.widget.shops.convert':
        	temp['method']='taobao.taobaoke.widget.shops.convert';
            temp['fields']=parame['fields'];
            temp['seller_nicks']=parame['seller_nicks'];
        break;
    }
    var cacheKey=hex_md5(arrToParam(temp));
    var cacheUrl=CACHEURL+'/'+method+'/'+cacheKey.substr(0,2)+'/'+cacheKey;
    return cacheUrl;
}

function saveCache(resp,cacheUrl){
	if(CACHETIME>0){
    	var saveCacheUrl='index.php?mod=ajax&act=jssdk_cache&json='+encodeURIComponent(json2str(resp).replace(/'/g,'’‘'))+'&dir='+encodeURIComponent(cacheUrl);
    	js_send(saveCacheUrl,1,'POST'); //缓存文件的url比较长，用post传输
    }
}

/* 
 * 检测对象是否是空对象(不包含任何可读属性)。 //如你上面的那个对象就是不含任何可读属性
 * 方法只既检测对象本身的属性，不检测从原型继承的属性。 
 */
function isOwnEmpty(obj) 
{ 
    for(var name in obj) 
    { 
        if(obj.hasOwnProperty(name)) 
        { 
            return false; 
        } 
    } 
    return true; 
}; 

/* 
 * 检测对象是否是空对象(不包含任何可读属性)。 
 * 方法既检测对象本身的属性，也检测从原型继承的属性(因此没有使hasOwnProperty)。 
 */
function isEmpty(obj) 
{ 
    for (var name in obj)  
    { 
        return false; 
    } 
    return true; 
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function taobaoTaobaokeWidgetItemsConvert(parame){
	
	if(parame['allow_fanli']==0){
		ddShowFxje({ddFxje:0});
		return false;
	}
	
	if(parame['num_iids']=='' || typeof parame['num_iids']=='undefined'){
    	return false;
    }
	
	var method='taobao.taobaoke.widget.items.convert';
    var fields='num_iid,nick,title,price,click_url,shop_click_url,item_location,seller_credit_score,pic_url,commission_rate,commission,commission_volume,volume,promotion_price';
	
    if(typeof parame['fields']!='undefined'){
    	fields=parame['fields'];
    }
    else{
    	parame['fields']=fields;
    }
    
    if(typeof parame['get_num']=='undefined'){
    	parame['get_num']=2;
    }
	
	if(typeof parame['renminbi']=='undefined'){
    	parame['renminbi']=0;
    }

    if(typeof parame['outer_code']=='undefined'){
    	parame['outer_code']=0;
    }
	
	if(typeof parame['user_level']=='undefined'){
    	parame['user_level']=0;
    }
	
	if(typeof parame['promotion_bl']=='undefined'){
    	parame['promotion_bl']=1;
    }
	
	if(typeof parame['tmall_fxje']=='undefined'){
    	parame['tmall_fxje']=0;
    }
	if(typeof parame['ju_fxje']=='undefined'){
    	parame['ju_fxje']=0;
    }
	
    if(CACHETIME>0){
		var cacheUrl=getCacheurl(method,parame);
    	$.ajax({
	   		url: cacheUrl,
			type: "GET",
			dataType:'json',
			success: function(resp){
	    		doItemsConvert(resp,parame);
			},
			error: function(XMLHttpRequest,textStatus, errorThrown){
           		var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],num_iids :parame['num_iids'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
           		getTopApi(apiParame,parame,cacheUrl);
       		}
		});
    }
    else{
    	var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],num_iids :parame['num_iids'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
        getTopApi(apiParame,parame,cacheUrl);
    }
}

function getAgain(apiParame,parame,cacheUrl){
	function foo(){
    	getTopApi(apiParame,parame,cacheUrl);
    	//alert('5秒到时，二次加载');
    };
    if(typeof parame['get_num_error']=='undefined'){
    	parame['get_num_error']=parame['get_num']+1;
    }
    parame['get_num_error']--;
    if(parame['get_num_error']>0){
    	againProcess=setTimeout(foo, GETAGAINTIME);
    	return againProcess;
    }
}

function getTopApi(apiParame,parame,cacheUrl){
    againProcess=getAgain(apiParame,parame,cacheUrl);
	TOP.api('rest','get',apiParame,function(resp){
    	clearInterval(againProcess);
		if(resp){
			if(resp.total_results==0 && parame['get_num']>0){ //增加命中率
            	parame['get_num']--;
            	getTopApi(apiParame,parame,cacheUrl);
                return true; //退出函数，停止以下代码运行
            }
			doItemsConvert(resp,parame);
            if(resp.total_results>0){
            	saveCache(resp,cacheUrl);
            }
        }
		else{
			var error_response={'code':1,'msg':'get fail'}
			ErrorLog(method,error_response);
		}
	});
}

function doItemsConvert(resp,parame){
	var ddFxje=0;
	var promotion_price=0;
	if(resp.error_response){
		ErrorLog(parame['method'],resp.error_response);
	}
	else{//debugObjectInfo(resp.taobaoke_items.taobaoke_item[0]);
    	if(resp.total_results==0){
        	if(parame['tmall_fxje']>0){
        		ddFxje=parame['tmall_fxje'];
    		}
    		else if(parame['ju_fxje']>0){
        		ddFxje=parame['ju_fxje'];
   			}
            else{
            	ddFxje=0;
            }
			var taobaokeItem={};
			taobaokeItem.ddFxje=ddFxje;
        }
        else if(resp.total_results==1){
        	commission=parseFloat(resp.taobaoke_items.taobaoke_item[0].commission);
			commission_rate=parseFloat(resp.taobaoke_items.taobaoke_item[0].commission_rate);
			promotion_price=parseFloat(resp.taobaoke_items.taobaoke_item[0].promotion_price);  //促销价
			price=parseFloat(resp.taobaoke_items.taobaoke_item[0].price);
			taobaokeItem=resp.taobaoke_items.taobaoke_item[0];
			if(promotion_price<price){
				commission=dataType(promotion_price*commission_rate/10000,2);
				taobaokeItem.promotion=1;
			}
			else{
				taobaokeItem.promotion=0;
			}
        	if(parame['onlyComm']==1){//只获取佣金即可
				//commission=dataType(commission*MONEYBL,DATA_TYPE);
				ddShowFxje(taobaokeItem);
				return true;
        	}
    		else{
            	if(parame['goods_type']=='ju'){
        			ddFxje=parame['ju_fxje'];
   				}
        		else if(commission>0){
    				if(parame['renminbi']==0){
						ddFxje=fenduan(commission,parame['user_level'],fxblArr,MONEYBL);
						ddFxje=dataType(ddFxje,DATA_TYPE);
					}
					else{
						ddFxje=fenduan(commission,parame['user_level'],fxblArr,1);
					}
    			}
				else if(parame['tmall_fxje']>0){
        			ddFxje=parame['tmall_fxje'];
    			}
				taobaokeItem.ddFxje=ddFxje;
        	}
        }
		else{
			var a=resp.taobaoke_items.taobaoke_item;
			var commArr=new Array();
			ddShowFxje(commArr);
		}

		if(ddFxje>=0){
			ddShowFxje(taobaokeItem);
		}
		else{
			ddArrayShowFxje(commArr);
		}
	}
}

function taobaoTaobaokeWidgetShopsConvert(parame){
	if(typeof parame['admin']=='undefined'){
    	parame['admin']=0;
    }
	if(parame['seller_nicks']=='' || typeof parame['seller_nicks']=='undefined'){
    	return 'miss nick';
    }
	else{
    	var method='taobao.taobaoke.widget.shops.convert';
    	var fields='shop_id,seller_nick,user_id,shop_title,click_url,commission_rate,seller_credit,shop_type,total_auction,auction_count';
    	
    	if(typeof parame['fields']!=='undefined'){
    		fields=parame['fields'];
    	}
    	else{
    		parame['fields']=fields;
    	}
    	
        if(CACHETIME>0){
			var cacheUrl=getCacheurl(method,parame);
        	$.ajax({
	    		url: cacheUrl,
				type: "GET",
				dataType:'json',
				success: function(resp){
		    		doShopsConvert(resp,parame);
				},
				error: function(XMLHttpRequest,textStatus, errorThrown){
            		var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],seller_nicks :parame['seller_nicks'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
            		TOP.api('rest','get',apiParame,function(resp){
                		if(isEmpty(resp)==false){
							doShopsConvert(resp,parame);
                    		saveCache(resp,cacheUrl);
                    	}
                    	else{
                    		shopsInfo['level']=-1;
                    	}
					});
        		}
			});
        }
    	else{
        	var apiParame={method:method, fields:fields,outer_code :parame['outer_code'],seller_nicks :parame['seller_nicks'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
            TOP.api('rest','get',apiParame,function(resp){
                if(isEmpty(resp)==false){
					doShopsConvert(resp,parame);
                    saveCache(resp,cacheUrl);
                 }
                 else{
					if(typeof(noShop)=="function"){
						noShop();
					}
                 }
			});
        }
    }
}

function doShopsConvert(resp,parame){
	shopsInfo=new Array();j=0;
	
	if(resp.error_response){
    	if(parame['admin']==1){
        	alert(resp.error_response.msg);
        }
		ErrorLog(parame['method'],resp.error_response);
	}
    else if(resp.total_results==0){
        if(typeof(noShop)=="function"){
			noShop();
		}
    }
	else{
		var shops=resp.taobaoke_shops.taobaoke_shop;
        //debugObjectInfo(shops[0]);
		for(var i in shops){
    		shopInfo=new Array();
    		shopInfo['seller_nick']=shops[i].seller_nick;
        	shopInfo['user_id']=shops[i].user_id;
    		shopInfo['seller_credit']=shops[i].seller_credit;
    		shopInfo['shop_type']=shops[i].shop_type;
                    
        	if(shopInfo['shop_type']=='B'){
        		shopInfo['level']=21;
        	}
        	else{
            	shopInfo['level']=shopInfo['seller_credit'];
        	}
    
    		if(parame['from']=='list'){
        	}
        	else{
        		shopInfo['auction_count']=shops[i].auction_count;
        		shopInfo['click_url']=shops[i].click_url;
        		shopInfo['commission_rate']=shops[i].commission_rate;
        		if(shopInfo['commission_rate']>0){
        			shopInfo['taoke']=1;
            		shopInfo['fanxianlv']=shopInfo['commission_rate'];
            		shopInfo['fxbl']=shopInfo['commission_rate'];
        		}
        		else{
            		shopInfo['taoke']=0;
            		shopInfo['fxbl']=0;
        		}
        
        		shopInfo['shop_id']=shops[i].shop_id;
        		shopInfo['shop_title']=shops[i].shop_title;
        		shopInfo['total_auction']=shops[i].total_auction;
        		//shopInfo['jump']="index.php?mod=jump&act=shop&url="+encodeURIComponent(encode64(shopInfo['click_url']))+"&pic="+encodeURIComponent(encode64(parame['logo']))+"&fan="+encodeURIComponent(shopInfo['fxbl'])+"&name="+encodeURIComponent(shopInfo['shop_title'])+"&sid="+shopInfo['shop_id'];
        	}
    		shopsInfo[j]=shopInfo;
        	j++;
    	}
    	if(i==0){
    		var shopGet=new Array();
    		shopGet['pic_path']=parame['pic_path'];
            shopGet['logo']=parame['logo'];
        	shopGet['cid']=parame['cid'];
        	shopGet['sid']=parame['sid'];
        	shopGet['item_score']=parame['item_score'];
        	shopGet['service_score']=parame['service_score'];
        	shopGet['delivery_score']=parame['delivery_score'];
        	shopGet['created']=parame['created'];
        	shopGet['title']=parame['title'];
        
        	shopGet['auction_count']=shopInfo['auction_count'];
       		shopGet['click_url']=shopInfo['click_url'];
        	shopGet['taoke']=shopInfo['taoke'];
        	shopGet['fanxianlv']=shopInfo['fanxianlv'];
        	shopGet['seller_credit']=shopInfo['seller_credit'];
			shopGet['level']=shopInfo['seller_credit'];
        	shopGet['seller_nick']=shopInfo['seller_nick'];
        	shopGet['total_auction']=shopInfo['total_auction'];
        	shopGet['user_id']=shopInfo['user_id'];
        	shopGet['shop_type']=shopInfo['shop_type'];
            if(shopGet['shop_type']=='B'){
            	shopGet['level']=21;
            }
            shopInfo['sid']=parame['sid']; //taobao.taobaoke.widget.shops.convert 返回的店铺id是错误的，所以从新更正
			shopInfo['jump']="index.php?mod=jump&act=shop&url="+encodeURIComponent(encode64(shopGet['click_url']))+"&pic="+encodeURIComponent(encode64(shopGet['logo']))+"&fan="+encodeURIComponent(shopGet['fanxianlv'])+"&name="+encodeURIComponent(shopGet['title'])+"&sid="+shopGet['sid'];
            shopInfo['detail_url']='http://shop'+parame['sid']+'.taobao.com';
			
            shopsInfo=shopInfo;
            if(parame['admin']==1 || (SHOPOPEN==1 && shopGet['fanxianlv']>0 && ((shopGet['level']>=SHOPSLEVEL && shopGet['level']<=SHOPELEVEL) || shopGet['level']==21))){
        		var url='index.php?mod=ajax&act=addshop&'+arrToParam(shopGet);
                if(parame['admin']==1){
                	url=url+'&admin=1';
                }
            	js_send(url,1);
            }
    	}
    	else{
    		//alert(shopsInfo[3]['seller_nick']);
    	}
		ddShowShopInfo(shopsInfo);
	}
}

function taobaoTaobaokeWidgetUrlConvert(parame){
	var method='taobao.taobaoke.widget.url.convert';
	
	if(typeof parame['outer_code']=='undefined'){
    	parame['outer_code']=0;
    }
    
    if(CACHETIME>0){
		var cacheUrl=getCacheurl(method,parame);
		$.ajax({
	    	url: cacheUrl,
			type: "GET",
			dataType:'json',
			success: function(resp){
		    	doUrlConvert(resp,parame);
			},
			error: function(XMLHttpRequest,textStatus, errorThrown){
            	var apiParame={method:method, outer_code :parame['outer_code'],url :parame['url'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
            	TOP.api('rest','get',apiParame,function(resp){
                	if(resp){
						doUrlConvert(resp,parame);
                    	saveCache(resp,cacheUrl);
                   	}
				});
        	}
		});
	}
    else{
		var apiParame={method:method, outer_code :parame['outer_code'],url :parame['url'],timestamp:JSSDK_TIME,sign:JSSDK_SIGN};
        TOP.api('rest','get',apiParame,function(resp){
        	if(resp){
				doUrlConvert(resp,parame);
                saveCache(resp,cacheUrl);
            }
		});
	}
}

function doUrlConvert(resp,parame){
	if(resp.error_response){
		ErrorLog(parame['method'],resp.error_response);
	}
	else{
        var theClickUrl=resp.taobaoke_item.click_url;
		doClickUrl(theClickUrl);
	}
}