
<?php 
 
use yii\helpers\Html;
use dm\helpsystem\client\components\HelpClientUtil;

?>
<ul class="home-navi">
 <?php 
 if(!empty($topicTree)){
	 foreach($topicTree as $topic)
	 {	$children ='';
	 	if(!empty($topic['children'])){
	 		$children = '<ul>';
	 		foreach($topic['children'] as $child){
	 			$children.='<li ><a href="#" 
	 				topicid = "'.$child["id"].'"
	 				sectionid = "'.$child["sectionId"].'"
	 				class ="topicItem" >'.Html::encode($child["title"]).'</a>';
	 				$children.= HelpClientUtil::createChildTree($child);
	 			$children.='</li>';
	 		}
	 		$children .= '</ul>';
	 	}
	 ?>
		<li><a href="#" 
			 	topicid =<?php echo $topic['id'];?> 
			 	sectionid=<?php echo $topic['sectionId'];?>
			 	class = "topicItem"><?php echo Html::encode($topic['title']);?></a>
			 	<?php echo $children;?>
		
		</li>
	<?php 
	 }
 }else{
echo  "<h4>No records found.</h4>";
}
 ?>
</ul>