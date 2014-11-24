   <?php 
   use yii\helpers\Html;
   use yii\helpers\Url;
   use yii\widgets\ActiveForm; 
   ?>
   
	<div class="contain">
    	<div class="topiclist">           
            <ul id="myTab" class="nav nav-tabs">
             	<li class="">
             		<?= Html::a(
             						"Topic",
              						urldecode(Url::to(["/helpsystem/admin/topic"])),
              				   		["title"=>"Topic"]
             		           );?>
                </li>
                <li class="active">
               		<?= Html::a(
	               					"Section",
	              					"#",
	              					["title"=>"Section"]
               				   );?>
               </li>             
           </ul>
       
        	<div class="col-md-11 Mtop20">
         		<div class="row well">
            		<?php $form=ActiveForm::begin(
									[   'id'=>'section-form',
									    'enableClientValidation'=>true,
										'validateOnSubmit'=>true,
										'validateOnChange'=>false,
	                      			    'options'=>['class'=>'commonForm'],
		
								]); ?>

                    	<div class="col-md-9">
	                    	<?=     $form->field($sectiontextModel,'Name')
	                    				 ->textInput(
	                          							['class'=> 'form-control'
	                          	   						 ]
	                    				 		     );
	                          ?>
                          		
                     	</div>
                    	<div class="col-md-3">
                      		<?= Html::submitButton(
                           				"Save",
                      					[
                      						"class" => "btn btn-primary saveButton",
                      						"title" => "Save"
            		                    ]
                      	                     );?> &nbsp;
                        	<?= Html::a(
                        				'Cancel',
                        				Url::to(["/helpsystem/admin/section"]),
                          			    [
                          			    	'title'=>'Cancel',
                          				    'class'=>'btn btn-default'
             			                ]
                          	      );?>
                    	</div>
                   		<?php ActiveForm::end(); ?>
          		</div>
            </div>
           <div class="col-md-11 Mtop20">
           		<div class="row">
                	<?php if(!empty($sectionList)){?>
                     	<table class="table table-bordered topiclist">
                        	<tr>                                      
                            	<th width="90%">Section</th>
                                <th width="90%">Section Id</th>
                                <th width="20%" class="text-center" colspan="2">Action</th>
                            </tr>
                            <?php foreach ($sectionList as $section){?>
                             <tr>                                      
                             	<td class="Wbreak"><?= ($section->sectionTexts)?(Html::encode($section->sectionTexts[0]->Name)):'';?></td>
                                <td class="Wbreak"><?= Html::encode($section->SectionId);?></td>
                                <td> <?=  Html::a(  'Edit',
                                					 Url::to(["/helpsystem/admin/section/update",
                                						"id"    => $section->SectionId]),
                                      				[
                                      					'title'  => 'Edit',
														'class'  => 'btn btn-primary btn-sm'
                                                       ]
									 );
									 ?>
								</td>
                                <td><?php if(empty($section->topics)){?>
                                       <?=   Html::a(
                                       				  'Delete',
                                       				   Url::to([
                                       					 	"/helpsystem/admin/section/delete",
                                       					  	'id' => $section->SectionId
                                       					  	]),
                                      					[
                                      						'title' => 'Delete',											
														    'data'  => ['confirm' => 
																	' Are you sure you want to delete this ?'],
														    'class' => "btn btn-danger btn-sm",
														 	'method'=> 'post',
                                           				]
									  				 );?>
									   <?php }?>
							     </td>
                             </tr>
                                   <?php }?>  
                         </table>
                        <?php }else{
                               	echo "<h4>No records found.</h4>";
                         }?>
                   </div> 
              </div>            
             <!-- Section tab closed --> 
                          
     </div>
</div>
<?php 

   $this->registerJs(
   "
   $('body').on('beforeSubmit', 'form#section-form', function() {
   var form = $(this);
   disableSubmit(form);
   });");
   ?>