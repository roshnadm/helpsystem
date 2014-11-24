<?php

/**
 * TopicController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\client\controllers;

use Yii;
use yii\web\Request;
use dm\helpsystem\components\DMController;
use dm\helpsystem\client\models\dao\TopicDao;

/**
 * TopicController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

/**
 * TopicController Class is used to list all topics under a particular section 
 * and also to display content of an individual topic selected. 
 */
class TopicController extends DMController
{
	/**
	 * Index function will return list of all available topics under a particular
	 * section when a section Id is passed to it. If a Topic Id is passed then
	 * Index function will return Text(Content) related to that topic Id.  
	 */
	public function actionIndex(){
		
		$sectionId	= Yii::$app->request->post('sectionId', 0);//Section Id
		$topicId	= Yii::$app->request->post('topicId', 0);//Topic Id
		
		$topicDao  = new TopicDao();
		$data      = $topicDao->getSection($sectionId);//Get List of all topics under the particular section id passed as parameter
		$topicTree = $this->getTopicTree($data);
		return $this->renderPartial(
								'index',
								[
									'topicTree'  => $topicTree,
									 'sectionId' => $sectionId,
								]);
	}
	
	/**
	 * actionView is public function
	 * This function is called to get
	 * single topic details in the help widget
	 */
	public function actionView(){
		$sectionId	=  Yii::$app->request->post('sectionId', 0);//Section Id
		$topicId	=  Yii::$app->request->post('topicId', 0);//Topic Id
		$next       = 0;
		$prev       = 0;
		$topicDao   = new TopicDao();
		//Get List of all topics under the particular section id passed as parameter
		$data       = $topicDao->getSection($sectionId);
		if (!empty($data)){
			$topicTree = $this->getTopicTree($data);
			$topic     = $topicDao->getTopic($topicId);
			$page      = $this->createNextPre($topicTree);//Get all pages.
			
			$index = array_search($topicId, array_values($page));//Current Page(Index of Current Topic Id)
			$next  = ($index < count($page)-1)?$page[$index+1]:0;//Next page(Next Topic Id)
			$prev  = ($index != 0)?$page[$index-1]:0;//Previous page(Previous Topic Id)
			
			return $this->renderPartial(
					'topic',
					[
						'topic'     => $topic,
						'sectionId' => $sectionId,
						'topicId'   => $topicId,
						'next'      => $next,
						'prev'      => $prev,
					]);
		}
	}
	
	/**
	 *  *
	 * @param $data:- Contains list of all topics available under a particular section
	 * This function will return an array of Topic Id's for Pagination.
	 * @return $page array
	 */
	private function buildTree($data)
	{
		$page = [];
		foreach($data as $topic){
			$page[] = $topic->TopicId;
			if (!empty($topic->topics)){
				foreach($topic->topics as $child){
					$page[] = $child->TopicId;
					if ($child->topics){
						$children = $this->getChildTopicId($child);
						foreach ($children as $sub){
							$page[] = $sub;
						}
					}
				}
			}
		 }
		 return $page;
	}
	/**
	 * Returns all Sub Topics of a given n Topic.
	 * It further returns the sub topics of the child Topics until it's empty.  
	 * @param integer $topic
	 * @return $children array
	 */
	private function getChildTopicId($topic){
		if (!empty($topic->Topics)){
			$children = [];
			foreach ($topic->Topics as $child){
				$children[] = $child->TopicId;
				if ($child->Topics){
					$subChildren = $this->getChildTopicId($child);
					foreach ($subChildren as $sub){
						$children[] = $sub;
					}
				}
			}
			return $children;
		}
	}
	
	/**
	 * Returns the topic tree 
	 * @param array $topicList
	 * @return $topicTree array
	 */
	private function getTopicTree($topicList){
		$topicTree = [];
	
		if (!empty($topicList)){
			foreach ($topicList as $topic){
				$children = '';
				if (!empty($topic->topics)){
					foreach ($topic->topics as $child){
						$children[]=
						[
								'id'        => $child->TopicId,
								'title'     => $child->topicTexts[0]->Title,
								'sectionId' => $child->SectionId,
								'children'  => $this->createChildTree($child)
						];
					}
						
				}
				$topicTree[] = [
						'id'         => $topic->TopicId,
						'title'      => $topic->topicTexts[0]->Title,
						'sectionId'  => $topic->SectionId,
						'children'   => $children	
			         	];   
			}
		}
		return $topicTree;
	
	}
	
	/**
	 * Returns all pages of the given topic tree as an array of topicId's
	 * @param array $topicTree
	 * @return $page array
	 */
	private function createNextPre($topicTree){
		$page = [];
		
		foreach($topicTree as $topic)
		{
			$page[] = $topic['id'];
			if (!empty($topic['children'])){
					$children = [];
					$children = $this->createNextPre($topic['children']);
					$page     = array_merge($page,$children);
			}
		}
		return $page;
	}
	
	/**
	 * Returns all topics sorted by Order 
	 * @param Topic $topic
	 * @return $children array
	 */
	private function createChildTree($topic){
		$children = [];
		foreach ($topic->topics as $child){
				
			$children[$child->Order]=
		           [
					'id'        => $child->TopicId,
					'title'     => $child->topicTexts[0]->Title,
					'sectionId' => $child->SectionId,
					'children'  => $this->createChildTree($child)
			      ];	
		}
		ksort($children);
		return $children;
	}
}