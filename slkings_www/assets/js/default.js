/* Float */
$(function() {
  var offset = $("#floatbar").offset();
  var topPadding = -115;
     $(window).scroll(function() {
       if ($(window).scrollTop() > offset.top) {
          $("#floatbar").stop().animate({
              marginTop: 55
          });
        } else {
          $("#floatbar").stop().animate({
             marginTop: 0
         });
       };
    });
});




/* page top */
$( window ).scroll(function() {
	var scrollTop = $(window).scrollTop();

	if( scrollTop < 20 ){
		if(!$("#pagetop").hasClass("hide")){			
			$("#pagetop").addClass("hide");
		}
	} else {
		if($("#pagetop").hasClass("hide")){			
			$("#pagetop").removeClass("hide");
		}
	}
});



jQuery.fn.imageScroller = function(params){
	var p = params || {
		next:"buttonNext",
		prev:"buttonPrev",
		frame:"scrollerFrame",
		width:130,
		child:"a",
		auto:true
	}; 
	var _btnNext = $("#"+ p.next);
	var _btnPrev = $("#"+ p.prev);
	var _imgFrame = $("#"+ p.frame);
	var _width = p.width;
	var _child = p.child;
	var _auto = p.auto;
	var _itv;
	
	var turnLeft = function(){
		_btnPrev.unbind("click",turnLeft);
		if(_auto) autoStop();
		_imgFrame.animate( {marginLeft:-_width}, 'fast', '', function(){
			_imgFrame.find(_child+":first").appendTo( _imgFrame );
			_imgFrame.css("marginLeft",0);
			_btnPrev.bind("click",turnLeft);
			if(_auto) autoPlay();
		});
	};
	
	var turnRight = function(){
		_btnNext.unbind("click",turnRight);
		if(_auto) autoStop();
		_imgFrame.find(_child+":last").clone().show().prependTo( _imgFrame );
		_imgFrame.css("marginLeft",-_width);
		_imgFrame.animate( {marginLeft:0}, 'fast' ,'', function(){
			_imgFrame.find(_child+":last").remove();
			_btnNext.bind("click",turnRight);
			if(_auto) autoPlay(); 
		});
	};
	
	_btnNext.css("cursor","hand").click( turnRight );
	_btnPrev.css("cursor","hand").click( turnLeft );
	
	var autoPlay = function(){
	  _itv = window.setInterval(turnLeft, 3000);  //롤링 시간 설정 3000=3초
	};
	var autoStop = function(){
		window.clearInterval(_itv);
	};
	if(_auto)	autoPlay();
};



/* Floating Menu */
$(document).ready(function() {
	var fmenu = $( '.fmenu' ).offset();
		$( window ).scroll( function() {
			if ( $( document ).scrollTop() > 280 ) {
				$( '.fmenu' ).addClass( 'fixed' );
				$( '.fmenu-space' ).addClass( 'fmenu-space-fixed' );
			} else {
				$( '.fmenu' ).removeClass( 'fixed' );
				$( '.fmenu-space' ).removeClass( 'fmenu-space-fixed' );
			}
			if ( $( document ).scrollTop() > 180 ) {
				$( 'body' ).addClass( 'pdtop' );
			} else {
				$( 'body' ).removeClass( 'pdtop' );
			}
	});
});