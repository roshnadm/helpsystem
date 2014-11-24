<?php 
   use yii\helpers\Html;
   use yii\helpers\Url;
   use yii\widgets\ActiveForm;
 ?>

<div class="contain">
	<div class="topiclist">
		<ul id="myTab" class="nav nav-tabs">
	 		<li class="active"><?= Html::a(
 									"Topic",
 									"#",
	 								["title"=>"Topic"])?>
	 		</li>
	 		<li class=""><?= Html::a(
	 								"Section",
	 								 Url::to(["/helpsystem/admin/section"]),
	 							     ["title"=>"Section"])?>
	 		</li>              
		</ul>
            
		<div class="col-md-12 Mtop20">
    		<div class="row">
	        	<div class="col-md-6">
	            	<?php 
	                	$form=	$form=ActiveForm::begin([
			                	'id'=>'topicIndex-form',
								'action'=> Url::to(["/helpsystem/admin/topic/index"]),
								'options'=>["style"=>"margin:0;"]
								]);
	                	?>
	                	<?= Html::dropDownList(
	                					"sectionId",
	                					$sectionId,
										$sectionList,
										[
											'onChange' => 'this.form.submit();',
											'prompt'   => 'Please Select',
											'class'    => 'form-control']);
					    ?>
						<?php ActiveForm::end(); 	?>
	             </div>
	             <div class="col-md-3 text-right">
		               <?=  Html::a(
		             				"Add Topics",
	              					 Url::to(["/helpsystem/admin/topic/create",
	              					        "sectionId"=>$sectionId]),
	              				     [
	              				     	"title"=>"Add Topics",
	              						"class"=> "btn btn-success btn-sm"
	                   				]);
	                   ?>
	                   <?=  Html::a("
	   								Reorder Topics",
	              					Url::to(["/helpsystem/admin/topic/reordersection",
	              					         "sectionId"=>$sectionId]),
	              				    [
	              				       "title" =>"Reorder Topics",
	              					    "class"=> "btn btn-success btn-sm"
	                   		    	]);
	                   ?>
	             </div>
       	 	</div>
    	</div>
     	<div class="col-md-12 Mtop20">
     		<div class="row">
           		<?php if(!empty($topicList)){?>
        			<table class="table table-bordered" width="100%">
		            	<tr>
		                	<th width="40%">Name</th>
		            		<th width="40%">Section</th>
		            		<th width="40%">Topic Id</th>
		                	<th width="20%" class="text-center" colspan="2">Action</th>
		            	</tr>

              			<?php foreach ($topicList as $topic){ ?>
           					<tr>
			                	<td class="Wbreak"><?= Html::encode($topic->topicTexts[0]->Title);?></td>
			                	<td class="Wbreak"><?= $topic->section->sectionTexts 
			                						   ? Html::encode($topic->section->sectionTexts[0]->Name)
			                	                       : '';?></td>
			                	<td class="Wbreak"><?= Html::encode($topic->TopicId);?></td>
			                	<td>
               					<?= Html::a(
               									'Edit',
               									  
               									 	Url::to([
               									 		"/helpsystem/admin/topic/update",
		                    		     		   		'id'=>$topic->TopicId,
		                    		     		   		'pno'=>$pageNo
		                    		     		   ])
		                    		            ,
               								     [
               								    	'class'=>'btn btn-primary btn-sm',
                        							'title' => 'Edit'
                        
               								    ]);
                   		       ?>
                    	       </td>
		               		<td>
		                    	<?= Html::a(
	                    				'Delete',
	                    		         Url::to([
	                    		        		"/helpsystem/admin/topic/delete", 
	                    		                 'id'=>$topic->TopicId,
	                    		                 'sectionId'=>$sectionId
	                    		                ]),
		                    		      
		                        	    [
		                        	    	'title'  => 'Delete',
									
									        'data' => ['confirm'=>'Related topics will also be deleted. Are you sure you want to delete this ?'],
									        'class'=>'btn btn-danger btn-sm']
									     );?>
		               		</td>
            			</tr>
    				<?php }?>
			</table>
         	<?php }else{?>
         	<h4>No records found.</h4>
          	<?php }?>
            <?php 
                 echo  $this->render(
                 		"pagination",
                 		[
                  			
                  			'pages'=>$pages,
                  			'sectionId'=>$sectionId
                 		 ])?>
  		</div> <!-- Row Closed -->
	</div>
</div>
</div>