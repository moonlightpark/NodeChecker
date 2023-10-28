(function(a){function m(b,c){var d=a(c);return d.length<2?d:b.parent().find(c)}function j(b,c){var d=this,C=b.add(d),h=b.children(),k=0,f=c.vertical;g||(g=d);h.length>1&&(h=a(c.items,b));a.extend(d,{getConf:function(){return c},getIndex:function(){return k},getSize:function(){return d.getItems().size()},getNaviButtons:function(){return o.add(n)},getRoot:function(){return b},getItemWrap:function(){return h},getItems:function(){return h.children(c.item).not("."+c.clonedClass)},move:function(a,c){return d.seekTo(k+
a,c)},next:function(a){return d.move(1,a)},prev:function(a){return d.move(-1,a)},begin:function(a){return d.seekTo(0,a)},end:function(a){return d.seekTo(d.getSize()-1,a)},focus:function(){return g=d},addItem:function(b){b=a(b);c.circular?(h.children("."+c.clonedClass+":last").before(b),h.children("."+c.clonedClass+":first").replaceWith(b.clone().addClass(c.clonedClass))):h.append(b);C.trigger("onAddItem",[b]);return d},seekTo:function(b,e,i){b.jquery||(b*=1);if(c.circular&&b===0&&k==-1&&e!==0)return d;
if(!c.circular&&b<0||b>d.getSize()||b<-1)return d;var n=b;b.jquery?b=d.getItems().index(b):n=d.getItems().eq(b);var j=a.Event("onBeforeSeek");if(!i&&(C.trigger(j,[b,e]),j.isDefaultPrevented()||!n.length))return d;n=f?{top:-n.position().top}:{left:-n.position().left};k=b;g=d;e===void 0&&(e=c.speed);h.animate(n,e,c.easing,i||function(){C.trigger("onSeek",[b])});return d}});a.each(["onBeforeSeek","onSeek","onAddItem"],function(b,e){a.isFunction(c[e])&&a(d).bind(e,c[e]);d[e]=function(b){b&&a(d).bind(e,
b);return d}});if(c.circular){var j=d.getItems().slice(-1).clone().prependTo(h),i=d.getItems().eq(1).clone().appendTo(h);j.add(i).addClass(c.clonedClass);d.onBeforeSeek(function(a,b,c){if(!a.isDefaultPrevented()){if(b==-1)return d.seekTo(j,c,function(){d.end(0)}),a.preventDefault();b==d.getSize()&&d.seekTo(i,c,function(){d.begin(0)})}});d.seekTo(0,0,function(){})}var o=m(b,c.prev).click(function(){d.prev()}),n=m(b,c.next).click(function(){d.next()});!c.circular&&d.getSize()>1&&(d.onBeforeSeek(function(a,
b){setTimeout(function(){a.isDefaultPrevented()||(o.toggleClass(c.disabledClass,b<=0),n.toggleClass(c.disabledClass,b>=d.getSize()-1))},1)}),c.initialIndex||o.addClass(c.disabledClass));c.mousewheel&&a.fn.mousewheel&&b.mousewheel(function(a,b){if(c.mousewheel)return d.move(b<0?1:-1,c.wheelSpeed||50),!1});if(c.touch){var e={};h[0].ontouchstart=function(a){a=a.touches[0];e.x=a.clientX;e.y=a.clientY};h[0].ontouchmove=function(a){if(a.touches.length==1&&!h.is(":animated")){var b=a.touches[0],c=e.x-b.clientX,
b=e.y-b.clientY;d[f&&b>0||!f&&c>0?"next":"prev"]();a.preventDefault()}}}c.keyboard&&a(document).bind("keydown.scrollable",function(b){if(c.keyboard&&!b.altKey&&!b.ctrlKey&&!a(b.target).is(":input")&&!(c.keyboard!="static"&&g!=d)){var e=b.keyCode;if(f&&(e==38||e==40))return d.move(e==38?-1:1),b.preventDefault();if(!f&&(e==37||e==39))return d.move(e==37?-1:1),b.preventDefault()}});c.initialIndex&&d.seekTo(c.initialIndex,0,function(){})}a.tools=a.tools||{version:"v1.2.5"};a.tools.scrollable={conf:{activeClass:"active",
circular:!1,clonedClass:"cloned",disabledClass:"disabled",easing:"swing",initialIndex:0,item:null,items:".items",keyboard:!0,mousewheel:!1,next:".next",prev:".prev",speed:400,vertical:!1,touch:!0,wheelSpeed:0}};var g;a.fn.scrollable=function(b){var c=this.data("scrollable");if(c)return c;b=a.extend({},a.tools.scrollable.conf,b);this.each(function(){c=new j(a(this),b);a(this).data("scrollable",c)});return b.api?c:this}})(jQuery);
(function(a){var m=a.tools.scrollable;m.autoscroll={conf:{autoplay:!0,interval:3E3,autopause:!0}};a.fn.autoscroll=function(j){typeof j=="number"&&(j={interval:j});var g=a.extend({},m.autoscroll.conf,j),b;this.each(function(){var c=a(this).data("scrollable");c&&(b=c);var d;c.play=function(){d||(d=setInterval(function(){c.next()},g.interval))};c.pause=function(){d=clearInterval(d)};c.stop=function(){c.pause()};g.autopause&&c.getRoot().add(c.getNaviButtons()).hover(c.pause,c.play);g.autoplay&&c.play()});
return g.api?b:this}})(jQuery);
(function(a){function m(g,b){var c=a(b);return c.length<2?c:g.parent().find(b)}var j=a.tools.scrollable;j.navigator={conf:{navi:".navi",naviItem:null,activeClass:"active",indexed:!1,idPrefix:null,history:!1}};a.fn.navigator=function(g){typeof g=="string"&&(g={navi:g});var g=a.extend({},j.navigator.conf,g),b;this.each(function(){function c(a,b,c){k.seekTo(b);if(o)location.hash&&(location.hash=a.attr("href").replace("#",""));else return c.preventDefault()}function d(){return f.find(g.naviItem||"> *")}
function j(b){var d=a("<"+(g.naviItem||"a")+"/>").click(function(d){c(a(this),b,d)}).attr("href","#"+b);b===0&&d.addClass(i);g.indexed&&d.text(b+1);g.idPrefix&&d.attr("id",g.idPrefix+b);return d.appendTo(f)}function h(a,b){var c=d().eq(b.replace("#",""));c.length||(c=d().filter("[href="+b+"]"));c.click()}var k=a(this).data("scrollable"),f=g.navi.jquery?g.navi:m(k.getRoot(),g.navi),l=k.getNaviButtons(),i=g.activeClass,o=g.history&&a.fn.history;k&&(b=k);k.getNaviButtons=function(){return l.add(f)};
d().length?d().each(function(b){a(this).click(function(d){c(a(this),b,d)})}):a.each(k.getItems(),function(a){j(a)});k.onBeforeSeek(function(a,b){setTimeout(function(){if(!a.isDefaultPrevented()){var c=d().eq(b);!a.isDefaultPrevented()&&c.length&&d().removeClass(i).eq(b).addClass(i)}},1)});k.onAddItem(function(a,b){b=j(k.getItems().index(b));o&&b.history(h)});o&&d().history(h)});return g.api?b:this}})(jQuery);
(function(a){function m(b,c,d){var g=this,h=b.add(this),k=b.find(d.tabs),f=c.jquery?c:b.children(c),l;k.length||(k=b.children());f.length||(f=b.parent().find(c));f.length||(f=a(c));a.extend(this,{click:function(b,c){var f=k.eq(b);typeof b=="string"&&b.replace("#","")&&(f=k.filter("[href*="+b.replace("#","")+"]"),b=Math.max(k.index(f),0));if(d.rotate){var e=k.length-1;if(b<0)return g.click(e,c);if(b>e)return g.click(0,c)}if(!f.length){if(l>=0)return g;b=d.initialIndex;f=k.eq(b)}if(b===l)return g;c=
c||a.Event();c.type="onBeforeClick";h.trigger(c,[b]);if(!c.isDefaultPrevented())return j[d.effect].call(g,b,function(){c.type="onClick";h.trigger(c,[b])}),l=b,k.removeClass(d.current),f.addClass(d.current),g},getConf:function(){return d},getTabs:function(){return k},getPanes:function(){return f},getCurrentPane:function(){return f.eq(l)},getCurrentTab:function(){return k.eq(l)},getIndex:function(){return l},next:function(){return g.click(l+1)},prev:function(){return g.click(l-1)},destroy:function(){k.unbind(d.event).removeClass(d.current);
f.find("a[href^=#]").unbind("click.T");return g}});a.each("onBeforeClick,onClick".split(","),function(b,c){a.isFunction(d[c])&&a(g).bind(c,d[c]);g[c]=function(b){b&&a(g).bind(c,b);return g}});d.history&&a.fn.history&&(a.tools.history.init(k),d.event="history");k.each(function(b){a(this).bind(d.event,function(a){g.click(b,a);return a.preventDefault()})});f.find("a[href^=#]").bind("click.T",function(b){g.click(a(this).attr("href"),b)});location.hash&&d.tabs=="a"&&b.find("[href="+location.hash+"]").length?
g.click(location.hash):(d.initialIndex===0||d.initialIndex>0)&&g.click(d.initialIndex)}a.tools=a.tools||{version:"v1.2.5"};a.tools.tabs={conf:{tabs:"a",current:"current",onBeforeClick:null,onClick:null,effect:"default",initialIndex:0,event:"click",rotate:!1,history:!1},addEffect:function(a,c){j[a]=c}};var j={"default":function(a,c){this.getPanes().hide().eq(a).show();c.call()},fade:function(a,c){var d=this.getConf(),g=d.fadeOutSpeed,h=this.getPanes();g?h.fadeOut(g):h.hide();h.eq(a).fadeIn(d.fadeInSpeed,
c)},slide:function(a,c){this.getPanes().slideUp(200);this.getPanes().eq(a).slideDown(400,c)},ajax:function(a,c){this.getPanes().eq(0).load(this.getTabs().eq(a).attr("href"),c)}},g;a.tools.tabs.addEffect("horizontal",function(b,c){g||(g=this.getPanes().eq(0).width());this.getCurrentPane().animate({width:0},function(){a(this).hide()});this.getPanes().eq(b).animate({width:g},function(){a(this).show();c.call()})});a.fn.tabs=function(b,c){var d=this.data("tabs");d&&(d.destroy(),this.removeData("tabs"));
a.isFunction(c)&&(c={onBeforeClick:c});c=a.extend({},a.tools.tabs.conf,c);this.each(function(){d=new m(a(this),b,c);a(this).data("tabs",d)});return c.api?d:this}})(jQuery);
(function(a){function m(g,b){function c(b){var c=a(b);return c.length<2?c:g.parent().find(b)}var d=this,j=g.add(this),h=g.data("tabs"),k,f=!0,l=c(b.next).click(function(){h.next()}),i=c(b.prev).click(function(){h.prev()});a.extend(d,{getTabs:function(){return h},getConf:function(){return b},play:function(){if(k)return d;var c=a.Event("onBeforePlay");j.trigger(c);if(c.isDefaultPrevented())return d;k=setInterval(h.next,b.interval);f=!1;j.trigger("onPlay");return d},pause:function(){if(!k)return d;var b=
a.Event("onBeforePause");j.trigger(b);if(b.isDefaultPrevented())return d;k=clearInterval(k);j.trigger("onPause");return d},stop:function(){d.pause();f=!0}});a.each("onBeforePlay,onPlay,onBeforePause,onPause".split(","),function(c,e){a.isFunction(b[e])&&a(d).bind(e,b[e]);d[e]=function(b){return a(d).bind(e,b)}});b.autopause&&h.getTabs().add(l).add(i).add(h.getPanes()).hover(d.pause,function(){f||d.play()});b.autoplay&&d.play();b.clickable&&h.getPanes().click(function(){h.next()});if(!h.getConf().rotate){var o=
b.disabledClass;h.getIndex()||i.addClass(o);h.onBeforeClick(function(a,b){i.toggleClass(o,!b);l.toggleClass(o,b==h.getTabs().length-1)})}}var j;j=a.tools.tabs.slideshow={conf:{next:".forward",prev:".backward",disabledClass:"disabled",autoplay:!1,autopause:!0,interval:3E3,clickable:!0,api:!1}};a.fn.slideshow=function(g){var b=this.data("slideshow");if(b)return b;g=a.extend({},j.conf,g);this.each(function(){b=new m(a(this),g);a(this).data("slideshow",b)});return g.api?b:this}})(jQuery);
(function(a){function m(b,c,d){var g=d.relative?b.position().top:b.offset().top,h=d.relative?b.position().left:b.offset().left,k=d.position[0];g-=c.outerHeight()-d.offset[0];h+=b.outerWidth()+d.offset[1];/iPad/i.test(navigator.userAgent)&&(g-=a(window).scrollTop());var f=c.outerHeight()+b.outerHeight();k=="center"&&(g+=f/2);k=="bottom"&&(g+=f);k=d.position[1];b=c.outerWidth()+b.outerWidth();k=="center"&&(h-=b/2);k=="left"&&(h-=b);return{top:g,left:h}}function j(b,c){var d=this,j=b.add(d),h,k=0,f=
0,l=b.attr("title"),i=b.attr("data-tooltip"),o=g[c.effect],n,e=b.is(":input"),r=e&&b.is(":checkbox, :radio, select, :button, :submit"),w=b.attr("type"),p=c.events[w]||c.events[e?r?"widget":"input":"def"];if(!o)throw'Nonexistent effect "'+c.effect+'"';p=p.split(/,\s*/);if(p.length!=2)throw"Tooltip: bad events configuration for "+w;b.bind(p[0],function(a){clearTimeout(k);c.predelay?f=setTimeout(function(){d.show(a)},c.predelay):d.show(a)}).bind(p[1],function(a){clearTimeout(f);c.delay?k=setTimeout(function(){d.hide(a)},
c.delay):d.hide(a)});l&&c.cancelDefault&&(b.removeAttr("title"),b.data("title",l));a.extend(d,{show:function(e){if(!h&&(i?h=a(i):c.tip?h=a(c.tip).eq(0):l?h=a(c.layout).addClass(c.tipClass).appendTo(document.body).hide().append(l):(h=b.next(),h.length||(h=b.parent().next())),!h.length))throw"Cannot find tooltip for "+b;if(d.isShown())return d;h.stop(!0,!0);var g=m(b,h,c);c.tip&&h.html(b.data("title"));e=e||a.Event();e.type="onBeforeShow";j.trigger(e,[g]);if(e.isDefaultPrevented())return d;g=m(b,h,
c);h.css({position:"absolute",top:g.top,left:g.left});n=!0;o[0].call(d,function(){e.type="onShow";n="full";j.trigger(e)});g=c.events.tooltip.split(/,\s*/);h.data("__set")||(h.bind(g[0],function(){clearTimeout(k);clearTimeout(f)}),g[1]&&!b.is("input:not(:checkbox, :radio), textarea")&&h.bind(g[1],function(a){a.relatedTarget!=b[0]&&b.trigger(p[1].split(" ")[0])}),h.data("__set",!0));return d},hide:function(b){if(!h||!d.isShown())return d;b=b||a.Event();b.type="onBeforeHide";j.trigger(b);if(!b.isDefaultPrevented())return n=
!1,g[c.effect][1].call(d,function(){b.type="onHide";j.trigger(b)}),d},isShown:function(a){return a?n=="full":n},getConf:function(){return c},getTip:function(){return h},getTrigger:function(){return b}});a.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","),function(b,e){a.isFunction(c[e])&&a(d).bind(e,c[e]);d[e]=function(b){b&&a(d).bind(e,b);return d}})}a.tools=a.tools||{version:"v1.2.5"};a.tools.tooltip={conf:{effect:"toggle",fadeOutSpeed:"fast",predelay:0,delay:30,opacity:1,tip:0,position:["top",
"center"],offset:[0,0],relative:!1,cancelDefault:!0,events:{def:"mouseenter,mouseleave",input:"focus,blur",widget:"focus mouseenter,blur mouseleave",tooltip:"mouseenter,mouseleave"},layout:"<div/>",tipClass:"tooltip"},addEffect:function(a,c,d){g[a]=[c,d]}};var g={toggle:[function(a){var c=this.getConf(),d=this.getTip(),c=c.opacity;c<1&&d.css({opacity:c});d.show();a.call()},function(a){this.getTip().hide();a.call()}],fade:[function(a){var c=this.getConf();this.getTip().fadeTo(c.fadeInSpeed,c.opacity,
a)},function(a){this.getTip().fadeOut(this.getConf().fadeOutSpeed,a)}]};a.fn.tooltip=function(b){var c=this.data("tooltip");if(c)return c;b=a.extend(!0,{},a.tools.tooltip.conf,b);typeof b.position=="string"&&(b.position=b.position.split(/,?\s/));this.each(function(){c=new j(a(this),b);a(this).data("tooltip",c)});return b.api?c:this}})(jQuery);
(function(a){var m=a.tools.tooltip;m.dynamic={conf:{classNames:"top right bottom left"}};a.fn.dynamic=function(j){typeof j=="number"&&(j={speed:j});var j=a.extend({},m.dynamic.conf,j),g=j.classNames.split(/\s/),b;this.each(function(){var c=a(this).tooltip().onBeforeShow(function(c,m){var h=this.getTip(),k=this.getConf();b||(b=[k.position[0],k.position[1],k.offset[0],k.offset[1],a.extend({},k)]);a.extend(k,b[4]);k.position=[b[0],b[1]];k.offset=[b[2],b[3]];h.css({visibility:"hidden",position:"absolute",
top:m.top,left:m.left}).show();var f;f=a(window);var l=f.width()+f.scrollLeft(),i=f.height()+f.scrollTop();f=[h.offset().top<=f.scrollTop(),l<=h.offset().left+h.width(),i<=h.offset().top+h.height(),f.scrollLeft()>=h.offset().left];a:{for(l=f.length;l--;)if(f[l]){l=!1;break a}l=!0}if(!l){f[2]&&(a.extend(k,j.top),k.position[0]="top",h.addClass(g[0]));f[3]&&(a.extend(k,j.right),k.position[1]="right",h.addClass(g[1]));f[0]&&(a.extend(k,j.bottom),k.position[0]="bottom",h.addClass(g[2]));f[1]&&(a.extend(k,
j.left),k.position[1]="left",h.addClass(g[3]));if(f[0]||f[2])k.offset[0]*=-1;if(f[1]||f[3])k.offset[1]*=-1}h.css({visibility:"visible"}).hide()});c.onBeforeShow(function(){var a=this.getConf();this.getTip();setTimeout(function(){a.position=[b[0],b[1]];a.offset=[b[2],b[3]]},0)});c.onHide(function(){this.getTip().removeClass(j.classNames)});ret=c});return j.api?ret:this}})(jQuery);(function(a){a.fn.hoverIntent=function(m,j){var g={sensitivity:7,interval:100,timeout:0},g=a.extend(g,j?{over:m,out:j}:m),b,c,d,C,h=function(a){b=a.pageX;c=a.pageY},k=function(f,i){i.hoverIntent_t=clearTimeout(i.hoverIntent_t);if(Math.abs(d-b)+Math.abs(C-c)<g.sensitivity)return a(i).unbind("mousemove",h),i.hoverIntent_s=1,g.over.apply(i,[f]);else d=b,C=c,i.hoverIntent_t=setTimeout(function(){k(f,i)},g.interval)},f=function(b){var c=jQuery.extend({},b),f=this;if(f.hoverIntent_t)f.hoverIntent_t=clearTimeout(f.hoverIntent_t);
if(b.type=="mouseenter"){if(d=c.pageX,C=c.pageY,a(f).bind("mousemove",h),f.hoverIntent_s!=1)f.hoverIntent_t=setTimeout(function(){k(c,f)},g.interval)}else if(a(f).unbind("mousemove",h),f.hoverIntent_s==1)f.hoverIntent_t=setTimeout(function(){f.hoverIntent_t=clearTimeout(f.hoverIntent_t);f.hoverIntent_s=0;g.out.apply(f,[c])},g.timeout)};return this.bind("mouseenter",f).bind("mouseleave",f)}})(jQuery);jQuery.cookie=function(a,m,j){if(arguments.length>1&&String(m)!=="[object Object]"){j=jQuery.extend({},j);if(m===null||m===void 0)j.expires=-1;if(typeof j.expires==="number"){var g=j.expires,b=j.expires=new Date;b.setDate(b.getDate()+g)}m=String(m);return document.cookie=[encodeURIComponent(a),"=",j.raw?m:encodeURIComponent(m),j.expires?"; expires="+j.expires.toUTCString():"",j.path?"; path="+j.path:"",j.domain?"; domain="+j.domain:"",j.secure?"; secure":""].join("")}j=m||{};b=j.raw?function(a){return a}:
decodeURIComponent;return(g=RegExp("(?:^|; )"+encodeURIComponent(a)+"=([^;]*)").exec(document.cookie))?b(g[1]):null};
(function(a){a.fn.equalHeights=function(m,j){tallest=m?m:0;this.each(function(){a(this).height()>tallest&&(tallest=a(this).height())});j&&tallest>j&&(tallest=j);return this.each(function(){a(this).height(tallest).css("overflow","auto")})}})(jQuery);(function(a){var m,j,g,b,c,d,C,h,k,f,l=0,i={},o=[],n=0,e={},r=[],w=null,p=new Image,u=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,A=/[^\.]\.(swf)\s*$/i,F,B=1,v=0,y="",q,t,s=!1,z=a.extend(a("<div/>")[0],{prop:0}),H=a.browser.msie&&a.browser.version<7&&!window.XMLHttpRequest,G=function(){j.hide();p.onerror=p.onload=null;w&&w.abort();m.empty()},I=function(){!1===i.onError(o,l,i)?(j.hide(),s=!1):(i.titleShow=!1,i.width="auto",i.height="auto",m.html('<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>'),
x())},D=function(){var b=o[l],c,e,f,g,h,k;G();i=a.extend({},a.fn.fancybox.defaults,typeof a(b).data("fancybox")=="undefined"?i:a(b).data("fancybox"));k=i.onStart(o,l,i);if(k===!1)s=!1;else{typeof k=="object"&&(i=a.extend(i,k));f=i.title||(b.nodeName?a(b).attr("title"):b.title)||"";if(b.nodeName&&!i.orig)i.orig=a(b).children("img:first").length?a(b).children("img:first"):a(b);f===""&&i.orig&&i.titleFromAlt&&(f=i.orig.attr("alt"));c=i.href||(b.nodeName?a(b).attr("href"):b.href)||null;if(/^(?:javascript)/i.test(c)||
c=="#")c=null;if(i.type){if(e=i.type,!c)c=i.content}else i.content?e="html":c&&(e=c.match(u)?"image":c.match(A)?"swf":a(b).hasClass("iframe")?"iframe":c.indexOf("#")===0?"inline":"ajax");if(e){e=="inline"&&(b=c.substr(c.indexOf("#")),e=a(b).length>0?"inline":"ajax");i.type=e;i.href=c;i.title=f;if(i.autoDimensions)i.type=="html"||i.type=="inline"||i.type=="ajax"?(i.width="auto",i.height="auto"):i.autoDimensions=!1;if(i.modal)i.overlayShow=!0,i.hideOnOverlayClick=!1,i.hideOnContentClick=!1,i.enableEscapeButton=
!1,i.showCloseButton=!1;i.padding=parseInt(i.padding,10);i.margin=parseInt(i.margin,10);m.css("padding",i.padding+i.margin);a(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){a(this).replaceWith(d.children())});switch(e){case "html":m.html(i.content);x();break;case "inline":if(a(b).parent().is("#fancybox-content")===!0){s=!1;break}a('<div class="fancybox-inline-tmp" />').hide().insertBefore(a(b)).bind("fancybox-cleanup",function(){a(this).replaceWith(d.children())}).bind("fancybox-cancel",
function(){a(this).replaceWith(m.children())});a(b).appendTo(m);x();break;case "image":s=!1;a.fancybox.showActivity();p=new Image;p.onerror=function(){I()};p.onload=function(){s=!0;p.onerror=p.onload=null;i.width=p.width;i.height=p.height;a("<img />").attr({id:"fancybox-img",src:p.src,alt:i.title}).appendTo(m);J()};p.src=c;break;case "swf":i.scrolling="no";g='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+i.width+'" height="'+i.height+'"><param name="movie" value="'+c+'"></param>';
h="";a.each(i.swf,function(a,b){g+='<param name="'+a+'" value="'+b+'"></param>';h+=" "+a+'="'+b+'"'});g+='<embed src="'+c+'" type="application/x-shockwave-flash" width="'+i.width+'" height="'+i.height+'"'+h+"></embed></object>";m.html(g);x();break;case "ajax":s=!1;a.fancybox.showActivity();i.ajax.win=i.ajax.success;w=a.ajax(a.extend({},i.ajax,{url:c,data:i.ajax.data||{},error:function(a){a.status>0&&I()},success:function(a,b,d){if((typeof d=="object"?d:w).status==200){if(typeof i.ajax.win=="function")if(k=
i.ajax.win(c,a,b,d),k===!1){j.hide();return}else if(typeof k=="string"||typeof k=="object")a=k;m.html(a);x()}}}));break;case "iframe":J()}}else I()}},x=function(){var b=i.width,c=i.height,b=b.toString().indexOf("%")>-1?parseInt((a(window).width()-i.margin*2)*parseFloat(b)/100,10)+"px":b=="auto"?"auto":b+"px",c=c.toString().indexOf("%")>-1?parseInt((a(window).height()-i.margin*2)*parseFloat(c)/100,10)+"px":c=="auto"?"auto":c+"px";m.wrapInner('<div style="width:'+b+";height:"+c+";overflow: "+(i.scrolling==
"auto"?"auto":i.scrolling=="yes"?"scroll":"hidden")+';position:relative;"></div>');i.width=m.width();i.height=m.height();J()},J=function(){var L,O;j.hide();if(b.is(":visible")&&!1===e.onCleanup(r,n,e))a.event.trigger("fancybox-cancel"),s=!1;else{s=!0;a(d.add(g)).unbind();a(window).unbind("resize.fb scroll.fb");a(document).unbind("keydown.fb");b.is(":visible")&&e.titlePosition!=="outside"&&b.css("height",b.height());r=o;n=l;e=i;if(e.overlayShow){if(g.css({"background-color":e.overlayColor,opacity:e.overlayOpacity,
cursor:e.hideOnOverlayClick?"pointer":"auto",height:a(document).height()}),!g.is(":visible")){if(H)a("select:not(#fancybox-tmp select)").filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one("fancybox-cleanup",function(){this.style.visibility="inherit"});g.show()}}else g.hide();t=Q();y=e.title||"";v=0;h.empty().removeAttr("style").removeClass();if(e.titleShow!==!1&&(L=a.isFunction(e.titleFormat)?e.titleFormat(y,r,n,e):y&&y.length?e.titlePosition=="float"?'<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">'+
y+'</td><td id="fancybox-title-float-right"></td></tr></table>':'<div id="fancybox-title-'+e.titlePosition+'">'+y+"</div>":!1,(y=L)&&y!==""))switch(h.addClass("fancybox-title-"+e.titlePosition).html(y).appendTo("body").show(),e.titlePosition){case "inside":h.css({width:t.width-e.padding*2,marginLeft:e.padding,marginRight:e.padding});v=h.outerHeight(!0);h.appendTo(c);t.height+=v;break;case "over":h.css({marginLeft:e.padding,width:t.width-e.padding*2,bottom:e.padding}).appendTo(c);break;case "float":h.css("left",
parseInt((h.width()-t.width-40)/2,10)*-1).appendTo(b);break;default:h.css({width:t.width-e.padding*2,paddingLeft:e.padding,paddingRight:e.padding}).appendTo(b)}h.hide();if(b.is(":visible"))a(C.add(k).add(f)).hide(),L=b.position(),q={top:L.top,left:L.left,width:b.width(),height:b.height()},O=q.width==t.width&&q.height==t.height,d.fadeTo(e.changeFade,0.3,function(){var b=function(){d.html(m.contents()).fadeTo(e.changeFade,1,E)};a.event.trigger("fancybox-change");d.empty().removeAttr("filter").css({"border-width":e.padding,
width:t.width-e.padding*2,height:i.autoDimensions?"auto":t.height-v-e.padding*2});O?b():(z.prop=0,a(z).animate({prop:1},{duration:e.changeSpeed,easing:e.easingChange,step:M,complete:b}))});else if(b.removeAttr("style"),d.css("border-width",e.padding),e.transitionIn=="elastic"){q=P();d.html(m.contents());b.show();if(e.opacity)t.opacity=0;z.prop=0;a(z).animate({prop:1},{duration:e.speedIn,easing:e.easingIn,step:M,complete:E})}else e.titlePosition=="inside"&&v>0&&h.show(),d.css({width:t.width-e.padding*
2,height:i.autoDimensions?"auto":t.height-v-e.padding*2}).html(m.contents()),b.css(t).fadeIn(e.transitionIn=="none"?0:e.speedIn,E)}},K=function(){(e.enableEscapeButton||e.enableKeyboardNav)&&a(document).bind("keydown.fb",function(b){if(b.keyCode==27&&e.enableEscapeButton)b.preventDefault(),a.fancybox.close();else if((b.keyCode==37||b.keyCode==39)&&e.enableKeyboardNav&&b.target.tagName!=="INPUT"&&b.target.tagName!=="TEXTAREA"&&b.target.tagName!=="SELECT")b.preventDefault(),a.fancybox[b.keyCode==37?
"prev":"next"]()});e.showNavArrows?((e.cyclic&&r.length>1||n!==0)&&k.show(),(e.cyclic&&r.length>1||n!=r.length-1)&&f.show()):(k.hide(),f.hide())},E=function(){a.support.opacity||(d.get(0).style.removeAttribute("filter"),b.get(0).style.removeAttribute("filter"));i.autoDimensions&&d.css("height","auto");b.css("height","auto");y&&y.length&&h.show();e.showCloseButton&&C.show();K();e.hideOnContentClick&&d.bind("click",a.fancybox.close);e.hideOnOverlayClick&&g.bind("click",a.fancybox.close);a(window).bind("resize.fb",
a.fancybox.resize);e.centerOnScroll&&a(window).bind("scroll.fb",a.fancybox.center);e.type=="iframe"&&a('<iframe id="fancybox-frame" name="fancybox-frame'+(new Date).getTime()+'" frameborder="0" hspace="0" '+(a.browser.msie?'allowtransparency="true""':"")+' scrolling="'+i.scrolling+'" src="'+e.href+'"></iframe>').appendTo(d);b.show();s=!1;a.fancybox.center();e.onComplete(r,n,e);var c,f;if(r.length-1>n&&(c=r[n+1].href,typeof c!=="undefined"&&c.match(u)))f=new Image,f.src=c;if(n>0&&(c=r[n-1].href,typeof c!==
"undefined"&&c.match(u)))f=new Image,f.src=c},M=function(a){var c={width:parseInt(q.width+(t.width-q.width)*a,10),height:parseInt(q.height+(t.height-q.height)*a,10),top:parseInt(q.top+(t.top-q.top)*a,10),left:parseInt(q.left+(t.left-q.left)*a,10)};if(typeof t.opacity!=="undefined")c.opacity=a<0.5?0.5:a;b.css(c);d.css({width:c.width-e.padding*2,height:c.height-v*a-e.padding*2})},N=function(){return[a(window).width()-e.margin*2,a(window).height()-e.margin*2,a(document).scrollLeft()+e.margin,a(document).scrollTop()+
e.margin]},Q=function(){var a=N(),b={},c=e.autoScale,d=e.padding*2;b.width=e.width.toString().indexOf("%")>-1?parseInt(a[0]*parseFloat(e.width)/100,10):e.width+d;b.height=e.height.toString().indexOf("%")>-1?parseInt(a[1]*parseFloat(e.height)/100,10):e.height+d;if(c&&(b.width>a[0]||b.height>a[1]))if(i.type=="image"||i.type=="swf"){c=e.width/e.height;if(b.width>a[0])b.width=a[0],b.height=parseInt((b.width-d)/c+d,10);if(b.height>a[1])b.height=a[1],b.width=parseInt((b.height-d)*c+d,10)}else b.width=Math.min(b.width,
a[0]),b.height=Math.min(b.height,a[1]);b.top=parseInt(Math.max(a[3]-20,a[3]+(a[1]-b.height-40)*0.5),10);b.left=parseInt(Math.max(a[2]-20,a[2]+(a[0]-b.width-40)*0.5),10);return b},P=function(){var b=i.orig?a(i.orig):!1,c={};b&&b.length?(c=b.offset(),c.top+=parseInt(b.css("paddingTop"),10)||0,c.left+=parseInt(b.css("paddingLeft"),10)||0,c.top+=parseInt(b.css("border-top-width"),10)||0,c.left+=parseInt(b.css("border-left-width"),10)||0,c.width=b.width(),c.height=b.height(),c={width:c.width+e.padding*
2,height:c.height+e.padding*2,top:c.top-e.padding-20,left:c.left-e.padding-20}):(b=N(),c={width:e.padding*2,height:e.padding*2,top:parseInt(b[3]+b[1]*0.5,10),left:parseInt(b[2]+b[0]*0.5,10)});return c},R=function(){j.is(":visible")?(a("div",j).css("top",B*-40+"px"),B=(B+1)%12):clearInterval(F)};a.fn.fancybox=function(b){if(!a(this).length)return this;a(this).data("fancybox",a.extend({},b,a.metadata?a(this).metadata():{})).unbind("click.fb").bind("click.fb",function(b){b.preventDefault();s||(s=!0,
a(this).blur(),o=[],l=0,b=a(this).attr("rel")||"",!b||b==""||b==="nofollow"?o.push(this):(o=a("a[rel="+b+"], area[rel="+b+"]"),l=o.index(this)),D())});return this};a.fancybox=function(b,c){var d;if(!s){s=!0;d=typeof c!=="undefined"?c:{};o=[];l=parseInt(d.index,10)||0;if(a.isArray(b)){for(var e=0,f=b.length;e<f;e++)typeof b[e]=="object"?a(b[e]).data("fancybox",a.extend({},d,b[e])):b[e]=a({}).data("fancybox",a.extend({content:b[e]},d));o=jQuery.merge(o,b)}else typeof b=="object"?a(b).data("fancybox",
a.extend({},d,b)):b=a({}).data("fancybox",a.extend({content:b},d)),o.push(b);if(l>o.length||l<0)l=0;D()}};a.fancybox.showActivity=function(){clearInterval(F);j.show();F=setInterval(R,66)};a.fancybox.hideActivity=function(){j.hide()};a.fancybox.next=function(){return a.fancybox.pos(n+1)};a.fancybox.prev=function(){return a.fancybox.pos(n-1)};a.fancybox.pos=function(a){s||(a=parseInt(a),o=r,a>-1&&a<r.length?(l=a,D()):e.cyclic&&r.length>1&&(l=a>=r.length?0:r.length-1,D()))};a.fancybox.cancel=function(){s||
(s=!0,a.event.trigger("fancybox-cancel"),G(),i.onCancel(o,l,i),s=!1)};a.fancybox.close=function(){function c(){g.fadeOut("fast");h.empty().hide();b.hide();a.event.trigger("fancybox-cleanup");d.empty();e.onClosed(r,n,e);r=i=[];n=l=0;e=i={};s=!1}if(!s&&!b.is(":hidden"))if(s=!0,e&&!1===e.onCleanup(r,n,e))s=!1;else if(G(),a(C.add(k).add(f)).hide(),a(d.add(g)).unbind(),a(window).unbind("resize.fb scroll.fb"),a(document).unbind("keydown.fb"),d.find("iframe").attr("src",H&&/^https/i.test(window.location.href||
"")?"javascript:void(false)":"about:blank"),e.titlePosition!=="inside"&&h.empty(),b.stop(),e.transitionOut=="elastic"){q=P();var j=b.position();t={top:j.top,left:j.left,width:b.width(),height:b.height()};if(e.opacity)t.opacity=1;h.empty().hide();z.prop=1;a(z).animate({prop:0},{duration:e.speedOut,easing:e.easingOut,step:M,complete:c})}else b.fadeOut(e.transitionOut=="none"?0:e.speedOut,c)};a.fancybox.resize=function(){g.is(":visible")&&g.css("height",a(document).height());a.fancybox.center(!0)};a.fancybox.center=
function(a){var c,f;if(!s&&(f=a===!0?1:0,c=N(),f||!(b.width()>c[0]||b.height()>c[1])))b.stop().animate({top:parseInt(Math.max(c[3]-20,c[3]+(c[1]-d.height()-40)*0.5-e.padding)),left:parseInt(Math.max(c[2]-20,c[2]+(c[0]-d.width()-40)*0.5-e.padding))},typeof a=="number"?a:200)};a.fancybox.init=function(){a("#fancybox-wrap").length||(a("body").append(m=a('<div id="fancybox-tmp"></div>'),j=a('<div id="fancybox-loading"><div></div></div>'),g=a('<div id="fancybox-overlay"></div>'),b=a('<div id="fancybox-wrap"></div>')),
c=a('<div id="fancybox-outer"></div>').append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>').appendTo(b),c.append(d=a('<div id="fancybox-content"></div>'),
C=a('<a id="fancybox-close"></a>'),h=a('<div id="fancybox-title"></div>'),k=a('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),f=a('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')),C.click(a.fancybox.close),j.click(a.fancybox.cancel),k.click(function(b){b.preventDefault();a.fancybox.prev()}),f.click(function(b){b.preventDefault();a.fancybox.next()}),a.fn.mousewheel&&b.bind("mousewheel.fb",
function(b,c){if(s)b.preventDefault();else if(a(b.target).get(0).clientHeight==0||a(b.target).get(0).scrollHeight===a(b.target).get(0).clientHeight)b.preventDefault(),a.fancybox[c>0?"prev":"next"]()}),a.support.opacity||b.addClass("fancybox-ie"),H&&(j.addClass("fancybox-ie6"),b.addClass("fancybox-ie6"),a('<iframe id="fancybox-hide-sel-frame" src="'+(/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank")+'" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(c)))};
a.fn.fancybox.defaults={padding:10,margin:40,opacity:!1,modal:!1,cyclic:!1,scrolling:"auto",width:560,height:340,autoScale:!0,autoDimensions:!0,centerOnScroll:!1,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:!0,hideOnContentClick:!1,overlayShow:!0,overlayOpacity:0.7,overlayColor:"#777",titleShow:!0,titlePosition:"float",titleFormat:null,titleFromAlt:!1,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",easingIn:"swing",easingOut:"swing",showCloseButton:!0,
showNavArrows:!0,enableEscapeButton:!0,enableKeyboardNav:!0,onStart:function(){},onCancel:function(){},onComplete:function(){},onCleanup:function(){},onClosed:function(){},onError:function(){}};a(document).ready(function(){a.fancybox.init()})})(jQuery);
//for videoplayer
$(document).ready(function() {	
		$("a.lightbox-flexvideo").fancybox({
			'overlayColor':'#333',
			'hideOnContentClick': false,
			'padding': 10,
			'width': 640,
			'height': 390,
			'autoScale': false,
			'scrolling': 'no',
			'iframe': true,
			'onClosed': function() {
				if($.browser.mozilla){
					 var myhref = $(this).attr('href');
					 if(typeof myhref != "undefined") {
						var plID = myhref.split('#wrap-');
						if(plID.length > -1)
							jwplayer(plID[1]).stop();				 	 
					 }
				}
			}			
		});
});

/**
 * @license 
 * jQuery Tools 1.2.5 Tabs- The basics of UI design.
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/tabs/
 *
 * Since: November 2008
 * Date:    Wed Sep 22 06:02:10 2010 +0000 
 */  
(function($) {
		
	// static constructs
	$.tools = $.tools || {version: '1.2.5'};
	
	$.tools.tabs = {
		
		conf: {
			tabs: 'a',
			current: 'current',
			onBeforeClick: null,
			onClick: null, 
			effect: 'default',
			initialIndex: 0,			
			event: 'click',
			rotate: false,
			
			// 1.2
			history: false
		},
		
		addEffect: function(name, fn) {
			effects[name] = fn;
		}
		
	};
	
	var effects = {
		
		// simple "toggle" effect
		'default': function(i, done) { 
			this.getPanes().hide().eq(i).show();
			done.call();
		}, 
		
		/*
			configuration:
				- fadeOutSpeed (positive value does "crossfading")
				- fadeInSpeed
		*/
		fade: function(i, done) {		
			
			var conf = this.getConf(),            
				 speed = conf.fadeOutSpeed,
				 panes = this.getPanes();
			
			if (speed) {
				panes.fadeOut(speed);	
			} else {
				panes.hide();	
			}

			panes.eq(i).fadeIn(conf.fadeInSpeed, done);	
		},
		
		// for basic accordions
		slide: function(i, done) {
			this.getPanes().slideUp(200);
			this.getPanes().eq(i).slideDown(400, done);			 
		}, 

		/**
		 * AJAX effect
		 */
		ajax: function(i, done)  {			
			this.getPanes().eq(0).load(this.getTabs().eq(i).attr("href"), done);	
		}		
	};   	
	
	var w;
	
	/**
	 * Horizontal accordion
	 * 
	 * @deprecated will be replaced with a more robust implementation
	 */
	$.tools.tabs.addEffect("horizontal", function(i, done) {
	
		// store original width of a pane into memory
		if (!w) { w = this.getPanes().eq(0).width(); }
		
		// set current pane's width to zero
		this.getCurrentPane().animate({width: 0}, function() { $(this).hide(); });
		
		// grow opened pane to it's original width
		this.getPanes().eq(i).animate({width: w}, function() { 
			$(this).show();
			done.call();
		});
		
	});	

	
	function Tabs(root, paneSelector, conf) {
		
		var self = this, 
			 istoggle = (conf.effect == 'toggle' || conf.effect == 'toggle-each'), // modification by HB
			 trigger = root.add(this),
			 tabs = root.find(conf.tabs),
			 panes = paneSelector.jquery ? paneSelector : root.children(paneSelector),			 
			 current;
			 
		
		// make sure tabs and panes are found
		if (!tabs.length)  { tabs = root.children(); }
		if (!panes.length) { panes = root.parent().find(paneSelector); }
		if (!panes.length) { panes = $(paneSelector); }
		
		
		// public methods
		$.extend(this, {				
			click: function(i, e) {
				var tab = tabs.eq(i);												 
				
				if (typeof i == 'string' && i.replace("#", "")) {
//					tab = tabs.filter("[href*=" + i.replace("#", "") + "]");
					var $anchors, $anchor; //**HB
					$anchors = tabs; //**HB JQuery Tools makes this assumption
					$anchor = $anchors.filter("[href*=" + i.replace("#", "") + "]"); //**HB
					if (!$anchor.length) { //**HB assumption incorrect
						$anchors = $('a',tabs),$anchor; //**HB - allow embedded anchors
						$anchor = $anchors.filter("[href*=" + i.replace("#", "") + "]"); //**HB
					}
//					i = Math.max(tabs.index(tab), 0);
					i = Math.max($anchors.index($anchor), 0); //**HB
					tab = tabs.eq(i); //**HB - establish tab number based on anchor number, assumes anchor embedded in each tab
				}
								
				if (conf.rotate) {
					var last = tabs.length -1; 
					if (i < 0) { return self.click(last, e); }
					if (i > last) { return self.click(0, e); }						
				}
				
				if (!tab.length) {
					if (current >= 0) { return self; }
					i = conf.initialIndex;
					tab = tabs.eq(i);
				}				
				
				// current tab is being clicked
				
				if (!istoggle)	{ // modification by HB
					if (i === current) { return self; }
				} // modification by HB
				// possibility to cancel click action				
				e = e || $.Event();
				e.type = "onBeforeClick";
				trigger.trigger(e, [i]);				
				if (e.isDefaultPrevented()) { return; }

				// call the effect
				effects[conf.effect].call(self, i, function() {

					// onClick callback
					e.type = "onClick";
					trigger.trigger(e, [i]);					
				});			
				
				// default behaviour
				current = i;
				if (!istoggle) { // modification by HB
					tabs.removeClass(conf.current);	
					tab.addClass(conf.current);
				} // modification by HB
				
				return self;
			},
			
			getConf: function() {
				return conf;	
			},

			getTabs: function() {
				return tabs;	
			},
			
			getPanes: function() {
				return panes;	
			},
			
			getCurrentPane: function() {
				return panes.eq(current);	
			},
			
			getCurrentTab: function() {
				return tabs.eq(current);	
			},
			
			getIndex: function() {
				return current;	
			}, 
			
			next: function() {
				return self.click(current + 1);
			},
			
			prev: function() {
				return self.click(current - 1);	
			},
			
			destroy: function() {
				tabs.unbind(conf.event).removeClass(conf.current);
				panes.find("a[href^=#]").unbind("click.T"); 
				return self;
			}
		
		});

		// callbacks	
		$.each("onBeforeClick,onClick".split(","), function(i, name) {
				
			// configuration
			if ($.isFunction(conf[name])) {
				$(self).bind(name, conf[name]); 
			}

			// API
			self[name] = function(fn) {
				if (fn) { $(self).bind(name, fn); }
				return self;	
			};
		});
	
		
		if (conf.history && $.fn.history) {
			$.tools.history.init(tabs);
			conf.event = 'history';
		}	
		
		// setup click actions for each tab
		tabs.each(function(i) { 				
			$(this).bind(conf.event, function(e) {
				self.click(i, e);
				return e.preventDefault();
			});			
		});
		
		// cross tab anchor link
		panes.find("a[href^=#]").bind("click.T", function(e) {
			self.click($(this).attr("href"), e);		
		}); 
		
		// open initial tab
//		if (location.hash && conf.tabs == "a" && root.find("[href=" +location.hash+ "]").length) {
		if (location.hash && root.find("[href=" +location.hash+ "]").length) { //**HB - allow embedded anchors
			self.click(location.hash);

		} else {
			if (conf.initialIndex === 0 || conf.initialIndex > 0) {
				self.click(conf.initialIndex);
			}
		}				
		
	}
	
	
	// jQuery plugin implementation
	$.fn.tabs = function(paneSelector, conf) {
		
		// return existing instance
		var el = this.data("tabs");
		if (el) { 
			el.destroy();	
			this.removeData("tabs");
		}

		if ($.isFunction(conf)) {
			conf = {onBeforeClick: conf};
		}
		
		// setup conf
		conf = $.extend({}, $.tools.tabs.conf, conf);		
		
		
		this.each(function() {				
			el = new Tabs($(this), paneSelector, conf);
			$(this).data("tabs", el); 
		});		
		
		return conf.api ? el: this;		
	};		
		
}) (jQuery); 

/* ===========================[ Extensions by Henrik Bechmann (bechmann.ca) henrik@bechmann.ca ]===================================*/
// extend jquery tools tabs
$.extend($.tools.tabs.conf,{slideUpSpeed:400,slideDownSpeed:400});
$.tools.tabs.addEffect('slide',function(i, done) {
	var conf = this.getConf(), $panes = this.getPanes();
	$panes.slideUp(conf.slideUpSpeed);
	$panes.eq(i).slideDown(conf.slideDownSpeed, done);
});
$.tools.tabs.addEffect('toggle',function(i, done) {
	var conf = this.getConf();
	var $tabs = this.getTabs();
	var $tab = $tabs.eq(i);
	if ($tab.hasClass(conf.current))
	{
		this.getPanes().eq(i).slideUp(conf.slideUpSpeed, done);
		$tabs.removeClass(conf.current);	
	}
	else
	{
		this.getPanes().slideUp(conf.slideUpSpeed);
		this.getPanes().eq(i).slideDown(conf.slideDownSpeed, done);
		$tabs.removeClass(conf.current);	
		$tab.addClass(conf.current);
	}
});

$.tools.tabs.addEffect('toggle-each',function(i, done) {
	var conf = this.getConf();
	var $tabs = this.getTabs();
	var $tab = $tabs.eq(i);
	if ($tab.hasClass(conf.current))
	{
		this.getPanes().eq(i).slideUp(conf.slideUpSpeed, done);
		$tab.removeClass(conf.current);	
	}
	else
	{
		this.getPanes().eq(i).slideDown(conf.slideDownSpeed, done);
		$tab.addClass(conf.current);
	}
});