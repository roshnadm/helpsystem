<?php

/**
 * TopicController class file.
 * @author  Digital Mesh <info@digitalmesh.com>
 * @copyright Copyright &copy; Digital Mesh 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package HelpSystem
 */

namespace dm\helpsystem\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

use dm\helpsystem\models\Section;
use dm\helpsystem\models\Topic;
use dm\helpsystem\models\SectionText;
use dm\helpsystem\models\TopicText;

use dm\helpsystem\components\DMController;
use dm\helpsystem\admin\components\DataManagement;
use dm\helpsystem\admin\models\TopicForm;

/**
 * TopicController Class is used to mange the CURD ot topic
 */
class TopicController extends DMController{
	/**
	 * function to initialise the controller
	 */
	public function init(){
		parent::init();
		$this->getView()->title = Yii::$app->name.' - '.'Topic';
		$this->setLayout();
	}
	
	/**
	 * set the layout for our controller
	 */
	private function setLayout(){
		$this->layout= Yii::$app->getModule('helpsystem')->pageLayout;
	}
	
	/**
	 * function to attach behaviours
	 */
	public function behaviors(){
		return  [
				'access' => [
						'class' => AccessControl::className(),
						'ruleConfig' => [
								'class' => 'dm\helpsystem\admin\components\AccessRule'
						],
						'rules' => [
								[
										'allow' => true,
										'actions' => ['index','update','delete','create',
										'ajaxtopictaglist','reordersection','treeviewdata',
										'reordertopic'],
								]
						]
				]
		];
	}
	
	/**
	 * List all topics
	 */
	public function actionIndex(){
		
		$pageNo         = Yii::$app->request->get("page",0)-1;
		$sectionId      = Yii::$app->request->get("sectionId",
						  Yii::$app->request->post("sectionId",''));
		$sectionList    = $this->getSectionList();

		$query     = Topic::find();
		if($sectionId){
			$query->andFilterWhere(
						[
							'SectionId'=>$sectionId
								
						]);
		}

		// config pagination properties
		$countQuery = clone $query;
		$pages      = new Pagination(['totalCount' => $countQuery->count()]);
		$pages->pageSize  = Yii::$app->getModule('helpsystem')
				                                ->getModule('admin')->topicPageLimit;		
		$pages->params    = ["sectionId" => $sectionId];
		$offset = $pages->pageSize * ($pageNo);
		if( $countQuery->count() < $offset ){
			$offset  = floor($countQuery->count()/$pages->pageSize)+1 ;
		}

        $topicList = $query->offset($offset)
	             ->limit($pages->pageSize)
	             ->orderBy('Order ASC')
		         ->all();
        
        $pages->setPage($pageNo);
        
		return $this->render(
				"index",
				[
					'topicList'       => $topicList,
					'sectionList'     => $sectionList,
					'sectionId'       => $sectionId,
					'pages'           => $pages,
					'pageNo'          => $pageNo+1
		      ]);
	}

	/**
	 * Get the total record Count
	 * @param Integer $sectionId
	 * @return count integer
	 */
	private function getTopicCount($sectionId){
		
		$query = Topic::find();
		if($sectionId){
			$query->andFilterWhere(
					[
						'SectionId'=>$sectionId
							
					]);
		}
		return $query->count();
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreate(){
		$topicForm        = new TopicForm();
		$sectionTextModel = new SectionText();
		$sectionList      = $this->getSectionList();
		
		$sectionId = Yii::$app->request->get("sectionId","");
		$topicList = [];
		$editTopic = 0;
		if(Yii::$app->request->isPost)
		{
			$request	             =  Yii::$app->request;
			$form                    = $request->post('TopicForm');
			$topicForm->body         = trim($form['body']);
			$topicForm->title        = trim($form['title']);
			$topicForm->parent       = $form['parent'];
			$topicForm->section      = $form['section'];
			$topicForm->sectionText  = trim($form['sectionText']);
			
			$topicModel = new Topic();
			$textModel  = new TopicText();
			
			if ($topicForm->validate()){
				if (DataManagement::createTopic(
						$topicForm,
						$topicModel,
						$textModel,
						$sectionTextModel,
						$topicForm->sectionText)
					){
					$this->redirect(
							[
								"index",
								"sectionId" => $sectionId
							]);
				}
			
			}		
		}
		
		$topicForm->section = $sectionId;
		return $this->render(
				"create",
				[
					'sectionList'      => $sectionList,
					'sectionId'        => $sectionId,
					'topicList'        => $topicList,
					'topicForm'        => $topicForm,
					'sectionTextModel' => $sectionTextModel,
					'parentId'         => '',
					'editTopic'        => $editTopic
		]);
		
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be reload the page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate(){
	   
		$id	    = Yii::$app->request->get("id",0);
		$pageNo	= Yii::$app->request->get("pno",0);
		
		$topicForm      = new TopicForm();
		$topicModel     = $this->loadModel($id);
		$topicList      = [];
		$editTopic      = 1;
		
		$topicForm->section = $topicModel->section->sectionTexts[0]->Name;
		$topicForm->title   = $topicModel->topicTexts[0]->Title;
		$topicForm->body    = $topicModel->topicTexts[0]->Body;
		
		if(!empty($topicModel->parent)){
			$topicForm->parent = $topicModel->parent->topicTexts[0]->Title;
		}
		else{
			$topicForm->parent = "No Parent";
		}
		$topicTextId = $topicModel->topicTexts[0]->TopicTextId;
		
		if (Yii::$app->request->isPost){
			$request	      = Yii::$app->request;
			$form		      = $request->post('TopicForm');
			$topicForm->body  = trim($form['body']);
			$topicForm->title = trim($form['title']);
			
			if ($topicForm->validate()){
				$textModel = TopicText::findOne($topicTextId);
				if(DataManagement::updateTopic(
						$topicForm,
						$textModel)){
					$this->redirect(
							Url::to(['/helpsystem/admin/topic/index',
								'page'=>$pageNo,
								'sectionId'=>$topicModel->SectionId]));
				}
				
			}
		}
		return $this->render(
				"create",
				[
					'topicList'      => $topicList,
					'topicForm'      => $topicForm,
					'editTopic'      => $editTopic
		        ]);
	
	}
	
	/**
	 * displays the parent of particular topic or "No Parent" of there is no parent topic on ajax call.
	 */
	public function actionGetsectiontopics()
	{
		$form      = Yii::$app->request->post("TopicForm");
		$sectionId = $form['section'];
		if($sectionId)
		{
			$topicList = $this->getParentChildTopics($sectionId);
			if(!empty($topicList))
			{
				echo Html::tag(
							'option',
							Html::encode("No Parent"),
							[
								'value' => 0	
							]);
				foreach($topicList as $eachTopic)
				{
					echo Html::tag(
							'option',
							Html::encode($eachTopic['label']),
							[
								'value' => $eachTopic['tid']
									
							]);
				}	
			}
			else
			{
				echo Html::tag(
						'option',
						Html::encode("No Parent"),
						[
							'value' => 0								
						]);
			}
		}
		
	}
	
	/**
	 * Returns an array of Topics of a particular Section
	 * @param integer $sectionId
	 * @return children array
	 */
	private function getParentChildTopics($sectionId)
	{
		$topicList = $this->getTopicOrderList($sectionId);
		$children  = [];
		if(!empty($topicList))
		{
			foreach ($topicList as $topic)
			{
				$children[] = [
								'label' => $topic->topicTexts[0]->Title,
						        'tid'   => $topic->TopicId
				               ];
				if(!empty($topic->topics))
				{
					foreach($topic->topics as $child)
					{
						$children[] = [
										'label'  => $child->topicTexts[0]->Title,
								        'tid'    => $child->TopicId								 
						              ];
					}
				}
			}
		}
		return $children;
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'topic' page.
	 * @param integer $id the ID of the model to be deleted
	 * @throws CHttpException 
	 */
	public function actionDelete($id,$sectionId)
	{
		// start transaction
		$transaction = Yii::$app->db->beginTransaction();
		try{
			if(Yii::$app->request->isGet){				
				$this->deleteTopic($id);
				$transaction->commit();
				$this->redirect(['index','sectionId'=>$sectionId]);
				
			}
			
		}catch (Exception $e ) {
		    $transaction->rollback();
			throw new HttpException($e);				
		  }
	}
	
	/**
	 * deleteTopic is a private function
	 * Here we written a recursive function
	 * to get delete all nested topics
	 * @param Integer $id
	 */
	private function deleteTopic($id){
		// get child topics
		$topicChildModel = Topic::find()
		                  ->andFilterWhere(['ParentId'=>$id])
		                  ->all();
		
		if (!empty($topicChildModel)){
			foreach ($topicChildModel as $topicChild){
				$this->deleteTopic($topicChild->TopicId);
			}
		}
		$topicText   = TopicText::deleteAll(
										[
											'TopicId' => $id												
										]);
	     $topicModel = $this->loadModel($id)
	                        ->delete();
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @throws CHttpException
	 * @return $model Object
	 */
	public function loadModel($id)
	{
		$model = Topic::findOne($id);
		if($model===null){
			throw new HttpException(404,'The requested page does not exist.');
		}
		return $model;
	}
	
	/**
	 * The browser will be redirected to ReOrderTopic page.
	 */
	public function actionReordersection(){
		$topicTree      = [];
		$sectionList    = $this->getSectionList();
		$sectionId      = Yii::$app->request->get("sectionId",0);
		
		if (Yii::$app->request->isPost){
			$sectionId = Yii::$app->request->post("sectionId",0);
			$topicList = $this->getTopicOrderList($sectionId);
			$topicTree = $this->getTopicTree($topicList);
		}
		return $this->render(
				"reorderSection",
				[
					'topicTree'=>$topicTree,
					'sectionList'=>$sectionList,
					'sectionId'=>$sectionId,
				]);
	}
	
	/**
	 * To Reorder the Topics as per the changes made in jstree 
	 */
	public function actionReordertopic(){
		
		$idList    = Yii::$app->request->post("idList");
		$ref       = Yii::$app->request->post("ref");
		
		$parentId  = (($ref)?$ref:null);
		$sectionId = Yii::$app->request->post("sectionId");
		
		if(!empty($idList))
		{
			$idList = explode(",", $idList);
			foreach($idList as $key => $val)
				{
					echo $key.' - Order <br>' ;
					echo $val.' - topic Id<br>';
					echo $parentId.'<br>';
					
					$this->updateOrder($key,$val,$parentId);
				}
		}
		Yii::$app->end();
	}
	
	/**
	 * Update the order and parent of a Topic model
	 * @param integer $order
	 * @param integer $topicId
	 * @param integer $parentId
	 */
	private function updateOrder($order,$topicId,$parentId)
	{
		$model = $this->loadModel($topicId);
		$model->Order = $order;
		$model->ParentId = $parentId;
		$model->save();
	}
	
	/**
	 * Display Topics and its child Topics of a particular Section
	 * @param integer $sectionId
	 * @param integer $id
	 */
	public function actionTreeviewdata($sectionId,$id){
		$topicList = $this->getTopicOrderList($sectionId,$id);
		$topicTree = $this->getTopicTree($topicList);
		print Json::encode($topicTree);
		Yii::$app->end();
	}
	
	/**
	 * Returns all Ordered Topic List as per Parent Topic or Section.
	 * @param integer $sectionId
	 * @param integer $id
	 * @return $result array
	 */
	private function getTopicOrderList($sectionId,$id=0){
		
		$query = Topic::find();
		if($id){
			$query->andFilterWhere(['ParentId'=>$id]);
		}else{
			$query->where('ParentId IS NULL');
			
		}
		$query->orderBy('order');
		$query->andFilterWhere(['SectionId' =>  $sectionId?$sectionId :0]);
		$query->with('topics');
		
		$result = $query->all();

		return $result;
	}
	
	/**
	 * Contructs a jstree in Topic Order
	 * @param array $topicList
	 * @return $topicTree array
	 */
	private function getTopicTree($topicList){
		$topicTree = [];
		
		if (!empty($topicList)){
			foreach ($topicList as $topic){
				$children = '';
				if (!empty($topic->Topics)){
					foreach ($topic->Topics as $child){
						$children[]=
						[
								'attr'     => [
												"id"  => $child->TopicId,
										        "rel" =>"default"
								              ],
								'data'     => $child->topicTexts[0]->Title,
								'tid'      => $child->TopicId,
								'pid'      => $child->ParentId,
								'state'    => 'closed',
								'children' => $this->createChildTree($child)
						];
					}
					
				}
				$topicTree[] = [
									'attr'     => [
													"id"  => $topic->TopicId,
											        "rel" => "default"
									              ],
									'data'     => $topic->topicTexts[0]->Title,
									'state'    => 'closed',
									'tid'      => $topic->TopicId,
						            'children' => $children,
						            'pid'      => $topic->ParentId];
				
			} 		
		}
		return $topicTree;
		
	}
	
	/**
	 * Contructs child jstree in Topic Order
	 * @param array $topic
	 * @return $children array
	 */
	private function createChildTree($topic){
		$children = '';
		foreach($topic->Topics as $child){
			
						$children[$child->Order]=
				    	[
								'attr'     => [
												"id"  => $child->TopicId,
										        "rel" =>"default"
								              ],
								'data'     => $child->TopicTexts[0]->Title,
								'tid'      => $child->TopicId,
								'pid'      => $child->ParentId,
								'state'    => 'closed',
								'children' => $this->createChildTree($child)
						];
						
		}
		return $children;
	}

	/**
	 * Returns a list of all Section name
	 * @return $sectionList array
	 */
	private function getSectionList(){
		$sections    = Section::find()->all();
		$sectionList = array();
		
		if (!empty($sections)){
			foreach ($sections as $section){
				$sectionList[$section->SectionId] = $section->sectionTexts ?
				                                    Html::encode($section->sectionTexts[0]->Name): '';
			}
		}
		return $sectionList;
	}
	
	/**
	 * To get a topic list of a specific section on ajax call.
	 * 
	 */
	public function actionAjaxtopictaglist(){
		$sectionId = Yii::$app->request->post("sectionId","");
		echo Html::tag(
				'option',
				Html::encode("Please select"),
				[
					'value'=>''
						
				]);
	
		if($sectionId){
			$query = Topic::find();
			$query->andFilterWhere(['SectionId'=>$sectionId]);
			$query->orderBy('Order');
			$topics = $query->all();
			
			if (!empty($topics)){
				foreach ($topics as $topic){
					echo Html::tag(
							'option',
							Html::encode($topic->topicTexts[0]->Title),
							[
								'value'=>$topic->TopicId
									
							]);
				}
			}
		}
		
		Yii::$app->end();
	}
	
}
