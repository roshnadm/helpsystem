<?php

/**
 * TopicDao class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\models\dao;

use Yii;
use dm\helpsystem\models\Topic;
use yii\helpers\VarDumper;

/**
 *
 * This Component is add dao functions
 *
 */
class TopicDao 
{
	/**
	 * getSection is a public function
	 * here we fetch all the topics under
	 * the sectionId reference
	 * @param INT $sectionId
	 * @return ARRAY $result
	 */
	public function getSection($sectionId)
	{
		$query = Topic::find();
		$query->where('ParentId IS NULL');
		$query->andFilterWhere(['SectionId' =>  $sectionId]);
		$query->orderBy('order');
		$query->with('topics');
		$result = $query->all();
		return $result;
	}
	
	/**
	 * getTopic is a public function
	 * here we fetch the topic details
	 * using topicId as reference
	 * @param INT $topicId
	 * @return ARRAY $result
	 */
	public function getTopic($topicId)
	{
		return $result = Yii::$app->db->createCommand(
				" SELECT Title,Body FROM hlp_TopicText WHERE TopicId = $topicId")
		->queryOne();
	}
	
	
	
}