 <?php 
 use dm\helpsystem\admin\assets\TopicAddAsset;

 use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\widgets\ActiveForm;
 
 use dm\helpsystem\dmeditor\DMEditor;
 $bundle = TopicAddAsset::register($this);
  ?>
 <div class="contain">
          <div class="topiclist">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><?= Html::a(
              						"Topic",
              						Url::to(["/helpsystem/admin/topic"]),
              					 	["title"=>"Topic"]);?></li>
              <li class=""><?= Html::a(
              					"Section",
              					 Url::to(["/helpsystem/admin/section"]),
              					 ["title"=>"Section"]);?></li>              
            </ul>            
         	<div class="col-md-12 Mtop20">
                 <?php $form = ActiveForm::begin ([
								'id'=>'topic-add-form',
								'enableClientValidation'=>true,
								//'focus'=>[$topicForm,'section'],
								 'validateOnSubmit'=>true,        		
                 				 'options'=>['class'=>'commonForm',
                 						'enctype'=>'multipart/form-data'
                 				],
                 		
							]); ?>
                   <div class="row">
                        <div class="col-md-3">Section*</div> 
                        <div class="col-md-6">
                      <?php 
                        if($editTopic)
                        {
                        	echo "<div class='Wbreak'>".Html::encode($topicForm->section)."</div>";
                        	echo '<div class="Mtop10">&nbsp;</div>';
                        }
                        else
                     {
                        	echo Html::hiddenInput(
                        				"topicAdminUrl",
                        			   Url::to(["/helpsystem/admin/topic/ajaxtopictaglist"]),['id'=>'topicAdminUrl']);
                       
					
							 echo $form->field(
							 		$topicForm,
							 		'section',[ 'template'=>'{input}{error}'])->dropDownList(
							 				$sectionList,
							 				[
							 						"prompt" => "Please select",
							 						'class'  => 'form-control',
							 						
							 				]
							 		);
							 echo $form->field(
							 		$topicForm,
							 		'sectionText',[ 'template'=>'{input}{error}'])->textInput(
							 				[
							 						'class'=>'form-control',
							 				]);
                            echo '<div class="sectionError">';
							 echo $form->field(
							 		$sectionTextModel,
							 		'Name',[ 'template'=>'{error}'])->textInput();
							 echo '</div>';
								
                        }
                        
				 		?>
                        </div>
                        <div class="col-md-3 Mtop4">
                        <?php 
                        if(!$editTopic){
                        	echo Html::a(
                        			"Add New Section",
                        			"#",
                        			 [
                        				   	 "class" => "btn btn-primary btn-sm topicAddButton",
                        					 "title" => "Add New Section"
                        			 ]
                        	       );
                        }?>
                       <?php 
                       	echo Html::img($bundle->baseUrl . '/img/revert.jpeg',
                                           			[
                        							"style"=>"display:none;width:20px;height:20px;",
                        							"class"=>"revertButton",
                       			               		'title'=>"Revert"
                       			               	]
                       	);
                        ?>
                        </div>
                   </div>
                   <div class="row ">
                        <div class="col-md-3">Title*</div> 
                        <div class="col-md-6">
                            
                              <?= $form->field(
                              		 $topicForm,
                              		'title',[ 'template'=>'{input}{error}'])->textInput(
                          		   [   
                          		   		'class'=> 'form-control'                        		   		
                                   ]);?>
                          	
                          	 <?php 
                          		 echo "<br />";
                          		 ?>
                        </div>
                        <div class="col-md-3 Mtop4"></div>
                   </div>
                   <div class="row ">
                    <div class="col-md-3"> Parent</div> 
                        <div class="col-md-6">
                             <?php
                        if($editTopic)
                        {
                        	echo "<div class='Wbreak' style='margin-botton:20px'>".Html::encode($topicForm->parent)."</div>";
                        	
                        }
                        else
                       {
                        	echo $form->field(
                        			 $topicForm,
                        			'parent',['template'=>'{input}{error}'])->dropDownList(
                        		  	$topicList,
								    [
							    		"prompt" => "No Parent",
										'class'  => 'form-control'
								   		
                                 	]
								); 						
                        } ?>
                        </div>
                        <div class="col-md-3 Mtop4"></div>
                   </div>
                   <div class="row Mtop20">
                         <div class="col-md-3">Body</div> 
                        <div class="col-md-6">
                        
                        <?php 
                        echo $form->field(
                        		$topicForm,
                        		'body',['template'=>'{input}{error}'])->textarea(                       				
                        				[
                        					'class'=> 'form-control'
                        							
                        				]
                        		);                      
                       
                        				dmEditor::widget([
												 'model'=> $topicForm,
												'attribute'=>'body',
                                                ]
											);
							?>
                        </div>                        
                   </div>  
                    <div class="row Mtop20">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                        <?= Html::submitButton("Save",array("class"=>"btn btn-primary saveButton","title"=>"Save"))?>
                          	&nbsp;<?= Html::a(
                          					'Cancel',
                          					 Url::to(["/helpsystem/admin/topic"]),
                          					 ['title'=>'Cancel',
                          					'class'=>'btn btn-default']
                          			 );
                          	?>
                        
                        
                        </div> 
                                               
                   </div>                 
                   <?php ActiveForm::end(); ?>
                </div>
          
          </div>
      </div>