	$( document ).ready(function() {
		_ImageInitializePageBuilder();
	});
	function _ImageInitializePageBuilder() {
              _ImageConfigureEvents(); 
              _clickEvents();
       
    }
	function _clickEvents(){
		$('.upload-inner').on('click', '.editorBrowseImage', function (e) {
			e.preventDefault();
			var $id = this.id;
			var $img = $("#"+$id).find("img");
			var $path = $img.attr("src");
			//alert($path);
			_openBrowseImage($path);
		});
	}
	function _openBrowseImage($image){
		_addToEditorPreview($image);
		window.top.close() ;
		window.top.opener.focus() ;
	}
	function _addToEditorPreview($image){
		window.opener.CKEDITOR.tools.callFunction(1, $image);
		
	}
    function _ImageConfigureEvents(){
    	_loadImages();
    }
    function _loadImages(){
    	_imageAjaxCal();
    }
    function _imageAjaxCal(){
    	$.ajax({
			url: _getImageBrowseUrl(),			
			data: {},
			//type: 'POST',
			async:true,
			dataType: 'json',
			cache: false,
			success: function($response) {		
				_createImageList($response);
		
			},
			error: function($error,$errorCode){
				alert("error");
			}
		});
    }
    function _createImageList($response){
    	var $j = 1;
		var $addData = false;
		var $outterDiv = '';
    	if($response.length > 0){
    		$.each($response, function(i, $file) {
    			if($j==1){
    				
    				if(i == 0){
    					$outterDiv = $("<div>").attr("class","inlinerow");
    				}else{
    					
    					$outterDiv = $("<div>").attr("class","inlinerow Mtop20")
    				}
    			}
    			if($j==6){
    				$(".upload-inner").append($outterDiv);
    				$j=1;
    				$addData = false;
    				
    				$outterDiv = $("<div>").attr("class","inlinerow Mtop20")
    			}
    		    var $innerDiv = $("<div>").attr("class","thumbnails");
    		    var $imageDiv = $("<div>").attr("class","blockdiv").append($("<a>").attr("class","editorBrowseImage").
    		    		attr("href","#").attr("id","editorBrowseImage"+i).append($("<img>")
    	    		    		.attr("src",$file.src).attr("title",$file.fileName)));
    		    var	$imageNameDiv = $("<div>").attr("class","blockdiv Mtop10")
    		    .html($file.fileName);
    		    $innerDiv.append($imageDiv).append($imageNameDiv);
    		    $outterDiv.append($innerDiv);
    		    $addData = true;
    		    $j++;
    		});
    		if($addData){
    			$(".upload-inner").append($outterDiv)
    		}
    	}
    }
    function _getImageBrowseUrl(){
    	return $("#imageBrowseUrl").val();
    }
    