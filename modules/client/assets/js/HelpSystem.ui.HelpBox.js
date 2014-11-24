	$( document ).ready(function() {
		
		_InitializePageBuilder();
	});
	function _InitializePageBuilder  () {
              
		_configureEvents();  
       
    };
    function _configureEvents () {
    	
    	_basicEvents();
    	_ajaxEvents();
    	
    };
    function _basicEvents(){
    	
    	_clickEvents();
    };
    function _ajaxEvents(){
   	 $(".overlay").ajaxStart(function(){
 		   $(this).show();
 		 });
	  	 $(".overlay").ajaxStop(function(){
	  		   $(this).hide();
	  	});
	  	 $(".overlay").ajaxComplete(function(){
	  		   $(this).hide();
	  	 });
   };
   function _clickEvents(){
    	
    	
    	$(".popUpBox").click(function(e){
    		var _self = $(this);
    		e.preventDefault();
    		var $sectionId = _self.attr("sectionid");
    		var $topicId = _self.attr("topicid");
    		$("#helpbox").remove();
    		_loadData(_self);
    	});
    	$('body').on('click', '.homebtn', function (e) {
    		var _self = $(this);
    		_loadData(_self);
    	});
    	$('body').on('click', '.topicItem', function (e) {
    		e.preventDefault();
    		var _self = $(this);
    		_loadData(_self);
    	});
    	$('body').on('click', '#prevLink', function (e) {
    		e.preventDefault();
    		var _self = $(this);
    		var $topicId = _self.attr('topicId');
    		if($topicId > 0){
    			_loadData(_self);
    		}
    	});
    	$('body').on('click', '#nextLink', function (e) {
    		e.preventDefault();
    		var _self = $(this);
    		var $topicId = _self.attr('topicid');
    		if($topicId > 0){
    			_loadData(_self);
    		}
    	});
    	$('body').on('click', '.helpclose', function (e) {
    		_hideHelpBox();
    	});
    	$('body .helpBody').on('click', 'a[href^="#"]', function (e) {
    		e.preventDefault();	
			$('div,id').animate({ scrollTop: $(this.hash).offset().top}, 500);			
			return false;			
					
		});
    }
    function _loadData($identifier){
    	var $topicId = $identifier.attr('topicid');
		var $sectionId = $identifier.attr('sectionid');
		var $url = _getTopicListUrl();
		if($topicId !=0){
			$url = _getTopicViewUrl();
		}
		
		_ajaxCal($url, $sectionId, $topicId);
    }
    function _ajaxCal($url,$sectionId,$topicId){
    	$.ajax({
			url: $url,			
			data: {				
				'sectionId':$sectionId,
				'topicId':$topicId
			},
			type: 'POST',
			async:true,
			dataType: 'html',
			cache: false,
			success: function(responseHTML) {				
				_setResponseHtml(responseHTML,$sectionId,$topicId);
		
			},
			error: function($error,$errorCode){
				alert("error");
			}
		});
    }
    function _setResponseHtml(responseHTML,$sectionId,$topicId){
    	
    	if($('div#helpbox').length){
    		$(".helpBoxContent").html(responseHTML);
    	}else{
    		_createHelpBox();
    		$(".helpBoxContent").html(responseHTML);
    		
    	}
    	
    	_setHeader();
    	_setCloseImg();
    	_setHomeButtonImg();
    	_setHomeLoaderImg();
    	_setHomeBtn($sectionId,0);
    	_moveHelpBox();
    	_resizeHelpBox();
    	$('#helpScrollerContent').animate({
    		   scrollTop: 0
    	}, 'slow');
    	
    }
    function _setHomeBtn($sectionId,$topicId){
    	$(".homebtn").attr("topicid",$topicId).
    	attr("sectionid",$sectionId);
    }
    function _showHelpBox(){
    	$("#helpbox").fadeIn();
    }
    function _hideHelpBox(){
    	$("#helpbox").remove();
    }
    function _moveHelpBox(){
    	 $("#helpbox").draggable({
    	        handle: ".helphead",
    	        cursor: "crosshair"
    	    });
    }
    function _getTopicListUrl(){
    	return $("#topicUrl").val();
    }
    function _getTopicViewUrl(){
    	return $("#topicViewUrl").val();
    }
    function _resizeHelpBox(){
    	$("#resizable").resizable ({}); 
    }
    function _getHeader(){
    	return $("#HelpoxHeader").val();
    }
    function _getassetUrl(){
    	return $("#clientAssetUrl").val();
    }
    function _setCloseImg(){
    	var $assetUrl = _getassetUrl();
    	$(".closebtnImg").attr("src",$assetUrl+"/img/close.png").attr("title","Close");
    }
    function _setHomeButtonImg(){
    	var $assetUrl = _getassetUrl();
    	$(".homebtnImg").attr("src",$assetUrl+"/img/home.png").attr("title","Home");
    }
    function _setHomeLoaderImg(){
    	var $assetUrl = _getassetUrl();
    	$(".loaderImg").attr("src",$assetUrl+"/img/ajax-loader.gif").attr("title","Loader");
    }
    function _setHeader(){
    	var $header = _getHeader();
    	$(".helpHeaderText").text($header);
    }
    function _createHelpBox(){
    	var $outerBox = $("<div>").attr("id", "helpbox").
    	attr("class","ui-widget-content");
    	var $innerBox = $("<div>").attr("id","resizable");
    	var $headerBox = $("<div>").attr("class","helphead");
    	var $helpHeaderText = $("<span>").attr("class","helpHeaderText");
    	$headerBox.append($helpHeaderText);
    	var $homebtn = $("<span>").attr("class","homebtn").append($("<img>").
    			attr("class","homebtnImg").attr("src","").attr("title","Home"));
    	$headerBox.append($homebtn);
    	var $helpclose = $("<span>").attr("class","helpclose").append($("<img>").
    			attr("class","closebtnImg").attr("src","").attr("title","Close"));
    	$headerBox.append($helpclose);
    	$innerBox.append($headerBox);
    	var $helpScrollerContent = $("<div>").attr("id","helpScrollerContent").
    	attr("class","helpcontents");
    	var $overlay = $("<div>").attr("class","overlay").append($("<div>").attr(
    			"class","loader").append($("<img>").attr("class","loaderImg").
    					attr("src","").attr("title","Loader")));
    	$helpScrollerContent.append($overlay);
    	var $helpBoxContent = $("<div>").attr("class","helpBoxContent");
    	$helpScrollerContent.append($helpBoxContent);
    	$innerBox.append($helpScrollerContent);
    	$outerBox.append($innerBox);
    	$("body").prepend($outerBox);
    	
    	
    }
  
		    
