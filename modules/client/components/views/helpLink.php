<?php

use yii\helpers\Html;
use yii\helpers\Url;

if($wrapperClass){
echo "<div class = '".$wrapperClass."'>";
}
 echo Html::a($title,
		"#",
					   ['class'=>'popUpBox helpPopUp '. $linkClass,
					   		 'topicid'=>$topicId,
					   		'sectionid'=>$sectionId
 		]);
 if($wrapperClass){
 	echo "</div>";
 }

 echo Html::hiddenInput("topicUrl",Url::to(["/helpsystem/client/topic/index"]),['id'=>'topicUrl']);
 echo Html::hiddenInput("topicViewUrl",Url::to(["/helpsystem/client/topic/view"]),['id'=>'topicViewUrl']);
 echo Html::hiddenInput("clientAssetUrl",$assetUrl,['id'=>'clientAssetUrl']);
 echo Html::hiddenInput("HelpoxHeader",$header,['id'=>'HelpoxHeader']);