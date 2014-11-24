<?php 
use yii\widgets\LinkPager;
?>
 <div class="text-right">  
                    
	<?php 
                      echo LinkPager::widget([
										    'pagination' => $pages,
											'prevPageLabel'=>'Prev',
											'nextPageLabel'=>'Next',
											'maxButtonCount'=> Yii::$app->getModule('helpsystem')
											                    ->getModule('admin')->maxButtonCount,
                      						'firstPageCssClass'=>'hidden',
                      						'lastPageCssClass'=>'hidden',
                      					//	'selectedPageCssClass'=>'active',
                      						'linkOptions'=>[
                      						'class'=>'pagination pagination-sm'	
                      		],
	]);?>                    
                                         
</div>

