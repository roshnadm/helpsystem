	$( document ).ready(function() {
		_TopicInitializePageBuilder();
	});
	function _TopicInitializePageBuilder() {
              _TopicConfigureEvents();  
       
    };
    function _TopicConfigureEvents() {
    	_TopicBasicEvents();
    
    	
    };
    function _TopicBasicEvents(){
    	
    	_TopiconChangeEvents();
    	_TopiconReadyEvents();
    	
    };
    function _TopiconReadyEvents(){
    	   	
    	$('body').on('beforeSubmit', 
    				'form#topic-add-form', function() {   	   
    	    var form = $(this);
    	    return ValidateSection(form);
    	    
    	  });
    	
    	if(    $(".field-sectiontext-name").length != 0  &&
    			$(".field-sectiontext-name .help-block").html()!="")  {
    
    		$(".field-topicform-sectiontext").addClass('has-error');
    		$(".field-topicform-section").hide();
    		$(".field-topicform-sectiontext .help-block").html($(".field-sectiontext-name .help-block").html());
    		$(".revertButton").show();
    		$(".topicAddButton").hide();
    		$(".sectionError").hide();
    	}else{
    		$(".sectionError").hide();
    		$(".field-topicform-sectiontext").hide();
    	}
		_TopicajaxGetTopics();
 

     };  
   function _TopiconChangeEvents(){
    	
		var __this = this;
    	$("#topicform-section").change(function(){
    		var $sectionId = __this._getSectionId();
    		_TopicajaxGetTopics();
    	});
    	$(".topicAddButton").click(function(e){
    		e.preventDefault();	
    		
    		$(".field-topicform-section").hide();
			$(".field-topicform-section").removeClass('has-error');
    		$(".field-topicform-section .help-block").html("");
    		$("#topicform-section").val("");
    		
    		$(".topicAddButton").hide();
    		
    		$(".field-topicform-sectiontext ").show();
    		$(".revertButton").show();
    		$(".sectionError").hide();
    		_TopicajaxGetTopics();
    	});

    	$(".revertButton").click(function(){
    		
    		$(".field-topicform-sectiontext").hide();
			$(".field-topicform-sectiontext").removeClass('has-error');
    		$(".field-topicform-sectiontext .help-block").html("");
     		$(".field-sectiontext-name .help-block").html(""); 		
    		$("#topicform-sectiontext").val("");
    		
    		$(".field-topicform-section").show();
    		$(".topicAddButton").show();
    		$(".revertButton").hide();
    		$(".sectionError").hide();
    	});
    	
    	if($("#topicForm-sectiontext").val())
    		{
    		$("#topicform-section").hide();
    		$("#Topicform-section").val("");
    		$(".topicAddButton").hide();
    		$("#topicform-sectiontext").show();
    		$(".revertButton").show();
    		_TopicajaxGetTopics();
    		}
    };
    function _TopicajaxGetTopics(){
    	
    	var $sectionId = _getSectionId();
    	var __this = this;
    	$.ajax({
			url: _getTopicAdminUrl(),			
			data: {				
				'sectionId':$sectionId
			},
			type: 'POST',
			async:true,
			dataType: 'html',
			cache: false,
			success: function(responseHTML) {				
				_TopicsetParentHtml(responseHTML);
		
			},
			error: function($error,$errorCode){
				alert("error");
			}
		});
    	
    }
    function _TopicsetParentHtml(responseHTML){
    	
    	$("#topicform-parent").html(responseHTML);
    	
    };
    function ValidateSection(form){
    	
    		var $sectionId = _getSectionId();
    		var $sectionText=_getSectionText();
    		if($sectionId =="" && $sectionText==""){
    			if ($('.field-topicform-section:visible').length !=0){
	    			$(".field-topicform-section .help-block").html("Section cannot be blank");
	    			$(".field-topicform-section").addClass('has-error');
	    	
    			}else{
	    			$(".field-topicform-sectiontext .help-block").html("Section cannot be blank");
	    			$(".field-topicform-sectiontext").addClass('has-error');
    			}
    			return false;
    		}
    		else{
    			$('.saveButton').attr('disabled', 'disabled');
    			$(".field-topicform-section").removeClass('has-error');
    			$(".field-topicform-sectiontext").removeClass('has-error');
    					
    			return true;
    		}
    }
    function _getTopicAdminUrl(){
    	return $("#topicAdminUrl").val();
    };
    function _getSectionId(){
    	return $("#topicform-section").val();
    };
    function _getSectionText(){
    	return $("#topicform-sectiontext").val();
    };
    function _getTopicId(){
    	return $("#parentId").val();
    };
		    
