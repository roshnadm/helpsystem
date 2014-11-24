  <?php 
  use yii\helpers\Html;
  ?>
  
  <?php if(!empty($topic)){?>
  <h4 class="helpTitle"><?= Html::encode($topic['Title']);?></h4>

  <p class = "helpBody"><?php echo $topic['Body']?></p>
  
       <!-- Footer -->
      <div class="help_footer">
      <ul class="pager">
      	<?php $prevClass = (($prev==0)?"disabled":"");
      	$nextClass = (($next==0)?"disabled":"");
      	?>
  		<li class ="<?php echo $prevClass;?>"><a href="#" 
  		topicid =<?php echo $prev;?> sectionid=<?php echo $sectionId;?> id="prevLink" title="Previous">Previous</a></li>
  		<li class ="<?php echo $nextClass;?>"><a href="#" 
  		topicid =<?php echo $next;?> sectionid=<?php echo $sectionId;?> id="nextLink" title="Next">Next</a></li>
	  </ul>
      </div>
      <?php }else{
echo  "<h4>No record found.</h4>";
}?>
      
      <!-- Footer Closed -->