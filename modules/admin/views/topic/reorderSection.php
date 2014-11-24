<?php 


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use dm\helpsystem\admin\assets\TopicReOrderAsset;

$bundle = TopicReOrderAsset::register($this);
 ?>
<div class="contain">
	<div class="topiclist">
	    <ul id="myTab" class="nav nav-tabs">
         	<li class="active"><?php echo Html::a(
         					"Topic",
              		Url::to(["/helpsystem/admin/topic/index",
              			        "sectionId"=>$sectionId]),
              		["title"=>"Topic"]);?></li>
              <li class=""><?php echo Html::a("Section",
              		Url::to(["/helpsystem/admin/section"]),
              		["title"=>"Section"]);?></li>               
   		</ul>
		<div class="col-md-12 Mtop20">                   
        	<div class="row">
            	<div class="col-md-12">Select a section</div>
            	<div class="col-md-4">
                	<?php 
	                	$form = ActiveForm::begin([
								'id'=>'topicOrder-form']);
	                        	echo Html::dropDownList("sectionId",
									$sectionId,
									$sectionList,
									['onChange'=>'this.form.submit();',
										'prompt'=>'Please Select',
										'class'=> 'form-control']);
	                	ActiveForm::end() 
	            	?>
            	</div>
       		</div>
		<div class="row">
			<div class="col-md-12 Mtop20">
				<div id="treeview"></div>
				<?php 
		        	echo Html::hiddenInput("assetUrl",$bundle->baseUrl,['id'=>'assetUrl']);
		        	echo Html::hiddenInput("treeViewDataUrl",Url::to([
						"/helpsystem/admin/topic/treeviewdata",
						"sectionId"=>$sectionId]),['id'=>'treeViewDataUrl']);
					echo Html::hiddenInput("treeViewReorderUrl",Url::to([
						"/helpsystem/admin/topic/reordertopic"]),['id'=>'treeViewReorderUrl']);
					echo Html::hiddenInput("treeJson",'',['id'=>'treeJson']);
				?>
			</div>
   		</div>                   
		</div>
	</div>
</div>      