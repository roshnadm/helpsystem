<?php
/**
 * DataManagement class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\components;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use dm\helpsystem\models\Section;
use dm\helpsystem\models\SectionText;


class DataManagement{
	/**
	 * createTopic is public function 
	 * Here we add new topic
	 * @param object $fromModel
	 * @param object $topicModel
	 * @param object $textModel
	 * @param string $sectionName
	 * @return boolean
	 */
	public function createTopic($fromModel,
				$topicModel,
				$textModel,
				$sectionTextModel,
				$sectionName=''){
		$sectionId ='';
		if ($sectionName){
			$sectionModel = new Section();
			$sectionId    = self::createSection($sectionName, 
												$sectionModel, 
												$sectionTextModel);
		}else{
			$sectionId	= $fromModel->section;
		}
		if ($sectionId){
			$parentId  = ($fromModel->parent) ? $fromModel->parent : NULL;
			$nextOrder = self::getNextOrder($parentId,$sectionId);
			
			$topicModel->ParentId	= $parentId;
			$topicModel->SectionId	= $sectionId;
			$topicModel->Order		= $nextOrder;
			$topicModel->Created	= new Expression('NOW()');
			
			if ($topicModel->save()){
				$textModel->Body    = $fromModel->body;
				$textModel->Title   = $fromModel->title;
				$textModel->TopicId = $topicModel->TopicId;
				$textModel->Created = new Expression('NOW()');
				$textModel->LCID    = Yii::$app->getModule('helpsystem')->languageCode;
				if($textModel->save()){
					return true;
				}
			}
		}else{
			$errors = $sectionTextModel->getErrors();
			if(empty($errors)){
				$fromModel->addError("section","Section cannot be blank");
			}
		}
		
	}
	/**
	 * updateTopic is a public function
	 * Here we update topics
	 * @param object $fromModel
	 * @param object $textModel
	 * @return boolean
	 */
	public function updateTopic($fromModel,$textModel){
		
		$textModel->Body     = trim($fromModel->body);
		$textModel->Title    = trim($fromModel->title);
		$textModel->Modified = new Expression('NOW()');
		
		if($textModel->save()){
			return true;
		}
	}
	
	/**
	 * createSection is a public function
	 * Here we add new section after duplicate validation
	 * @param array $form
	 * @param object $sectionModel
	 * @param object $sectiontextModel
	 * @return boolean
	 */
	public function createSection($name,
								  $sectionModel,
								  $sectiontextModel){
		if (trim($name)){
			if (self::validateSectionName($name)){
				if ($sectionModel->save()){
					$sectiontextModel->Name      = $name;
					$sectiontextModel->SectionId = $sectionModel->SectionId;
					$sectiontextModel->LCID      = Yii::$app->getModule('helpsystem')->languageCode;
					if ($sectiontextModel->save()){			
						return $sectionModel->SectionId;
					}
				}
			}else{
				$sectiontextModel->addError("Name","$name already exist...");
			}
		}else{
			$sectiontextModel->addError("Name","Name cannot be blank");
		}
	}
	
	/**
	 * updateSection is a public function
	 * Here we update section after 
	 * checking duplicate validation
	 * @param array $form
	 * @param object $sectiontextModel
	 * @param int $id
	 * @return boolean
	 */
	public function updateSection($name,$sectiontextModel,$id){
		if (trim($name)){
			if (self::validateSectionName($name,$id)){
				$sectiontextModel->Name = $name;
					if ($sectiontextModel->save()){
						return true;
					}
				}else{
					$sectiontextModel->addError("Name","$name already exist...");
				}
		}
		else{
			$sectiontextModel->addError("Name","Name cannot be blank");
		}
	}
	
	/**
		* Validate the section name to
		* conform its is unique
		* @param string $name
		* @param int $id
		* @return boolean
	*/
	private function validateSectionName($name,$id=0){
		
		$query = SectionText::find();
		$query->where(['Name'=> trim($name)]);
		$query->andFilterWhere(['LCID'=> Yii::$app->getModule('helpsystem')
				                                  ->languageCode]);		
		
		if ($id){
			$query->andFilterWhere(['!=','SectionId',$id]);
		}
		
		$result = $query->all();		
		
		if (!empty($result)){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * Returns the last order of Topic Order in a particular Parent-Topic Or Section.
	 * @param integer $parentId
	 * @param integer $sectionID
	 * @return $nextOrder integer
	 */
	private function getNextOrder($parentId, $sectionID)
	{
		if ($parentId)
		{
			$query = "SELECT  MAX(T.Order) AS maxcount  from hlp_Topic AS T 
			where ParentID = ".$parentId." AND SectionId = ".$sectionID;
		}
		else
		{
			$query = "SELECT  MAX(T.Order) AS maxcount  from hlp_Topic AS T 
			where ParentID IS NULL AND SectionId = ".$sectionID;
		}
		$maxOrderNumber = Yii::$app->db->createCommand($query)
							->queryOne();
		$nextOrder = $maxOrderNumber['maxcount'] + 1;
		$nextOrder = ($nextOrder)?($nextOrder+1):0;
		return $nextOrder;
	}	
}