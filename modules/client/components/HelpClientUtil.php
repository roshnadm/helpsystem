<?php

/**
 * HelpClientUtil class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\components;

use yii\helpers\Html;

class HelpClientUtil{
	
	/**
	 * Create a recursive Child Topic of the correcponding parent Topic
	 * @param object $topic
	 * @return $children string
	 */
	public function createChildTree($topic){
		$children ='';
		if(!empty($topic['children'])){
			$children = '<ul>';
			foreach($topic['children'] as $child){
			
				$children   .=' <li style="padding:0px"><a href="#"
	 									topicid   = "'.$child["id"].'"
	 									sectionid = "'.$child["sectionId"].'"
	 									class     = "topicItem" >'
								.Html::encode($child["title"]).'</a>';
					$children.=self::createChildTree($child);
				$children.='</li>';						
			}
			$children .= '</ul>';
		}
		
		return $children;
	}
	
}