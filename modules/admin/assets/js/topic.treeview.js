$( document ).ready(function() {
	_TreeInitializePageBuilder();
});
function _TreeInitializePageBuilder  () {
    
	_TreeconfigureEvents();  
   
};
function _TreeconfigureEvents () {
	_TreetreeView();
	
};
function _TreetreeView(){
	  $("#treeview").jstree({
		  	        "json_data" :{
		  	        	"ajax":{
		  	        		"url":_getTreeViewDataUrl(),
		  	        		"data" : function (n) { 
		  	        			return { id : n.attr ? n.attr("id") : 0 };  
		  	        		}
		  	        	}
		  	        },
		  	        "plugins" : [ "themes", "json_data", "ui","dnd" ]
		  	    })  .bind("move_node.jstree", function (e, data) {
	  	    		var topicList = new Array();
	  	    		var idList;
	  	    		data.rslt.np.children("ul").children("li").each(function (k,value) {
	  	    			topicList.push(value.id);
	  	    		});
	  	    		idList = topicList.join(",");
	  	    							$.ajax({
		  	    			                async : false,
		  	    			                type: 'POST',
		  	    			                url: _getReorderTopicUrl(),
		  	    			                data : {
		  	    			                	"idList":idList,
		  	    			                    "sectionId" : $("#sectionId").val(),
		  	    			                    "ref" : data.rslt.cr === -1 ? 0 : data.rslt.np.attr("id")
		  	    			                },
		  	    			                success : function (r) {
		  	    			                    if(r.status=="ERROR") {
		  	    		                        $.jstree.rollback(data.rlbk);
		  	    			                    }
		  	    			                    else {
		  	    			                        $(data.rslt.oc).attr("id", "node_" + r.id);
		  	    			                        if(data.rslt.cy && $(data.rslt.oc).children("UL").length) {
		  	    			                            data.inst.refresh(data.inst._get_parent(data.rslt.oc));
		  	    			                        }
		  	    			                    }
		  	    			                    $("#analyze").click();
		  	    			                }
		  	    			            });
		  	    			       
		  	    			    });
	
}
function _getReorderTopicUrl(){
	return $("#treeViewReorderUrl").val();
}
function _getTreeViewDataUrl(){
	return $("#treeViewDataUrl").val();
}
function _getAssetUrl(){
	return $("#assetUrl").val();
}
